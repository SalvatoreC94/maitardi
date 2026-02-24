<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected static function booted(): void
    {
        static::saved(function (Product $product) {
            $product->convertImagesToWebp();
        });
    }

    /**
     * Converte le immagini del prodotto in WebP (se non lo sono già).
     */
    protected function convertImagesToWebp(): void
    {
        if (! is_array($this->images) || empty($this->images)) {
            return;
        }

        // Controlla se GD supporta WebP
        if (! function_exists('imagecreatefromstring') || ! function_exists('imagewebp')) {
            return;
        }

        $disk = Storage::disk('public');
        $updated = false;
        $newImages = [];

        foreach ($this->images as $path) {
            // Se è già WebP, skip
            if (str_ends_with(strtolower($path), '.webp')) {
                $newImages[] = $path;
                continue;
            }

            if (! $disk->exists($path)) {
                $newImages[] = $path;
                continue;
            }

            try {
                $fullPath = $disk->path($path);
                $imageData = file_get_contents($fullPath);
                $gd = imagecreatefromstring($imageData);

                if (! $gd) {
                    $newImages[] = $path;
                    continue;
                }

                // Ridimensiona se troppo grande (max 1200px)
                $w = imagesx($gd);
                $h = imagesy($gd);
                if ($w > 1200 || $h > 1200) {
                    $ratio = min(1200 / $w, 1200 / $h);
                    $newW = (int) round($w * $ratio);
                    $newH = (int) round($h * $ratio);
                    $resized = imagecreatetruecolor($newW, $newH);
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                    imagecopyresampled($resized, $gd, 0, 0, 0, 0, $newW, $newH, $w, $h);
                    imagedestroy($gd);
                    $gd = $resized;
                }

                // Salva come WebP
                $webpPath = preg_replace('/\.[^.]+$/', '.webp', $path);
                $webpFullPath = $disk->path($webpPath);
                imagewebp($gd, $webpFullPath, 85);
                imagedestroy($gd);

                // Rimuovi il file originale
                if ($path !== $webpPath) {
                    $disk->delete($path);
                }

                $newImages[] = $webpPath;
                $updated = true;
            } catch (\Throwable $e) {
                Log::warning("Conversione WebP fallita per {$path}: {$e->getMessage()}");
                $newImages[] = $path;
            }
        }

        // Aggiorna il DB senza re-triggerare l'evento
        if ($updated) {
            static::withoutEvents(function () use ($newImages) {
                $this->update(['images' => $newImages]);
            });
        }
    }
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_cents',
        'sku',
        'is_visible',
        'images',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'images' => 'array',
    ];

    protected $appends = ['image_url', 'image_urls'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        $first = is_array($this->images) && count($this->images) ? $this->images[0] : null;
        return $first ? url('storage/' . ltrim($first, '/')) : 'https://picsum.photos/800/600?blur=2';
    }

    public function getImageUrlsAttribute(): array
    {
        if (!is_array($this->images) || empty($this->images)) {
            return [$this->image_url];
        }

        return array_map(fn ($p) => url('storage/' . ltrim($p ?? '', '/')), $this->images);
    }
}
