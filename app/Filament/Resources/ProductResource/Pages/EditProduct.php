<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

            Actions\Action::make('rimuovi_immagini')
                ->label('Rimuovi immagini')
                ->icon('heroicon-m-trash')
                ->color('danger')
                ->visible(fn () => is_array($this->record->images) && count($this->record->images))
                ->form([
                    Forms\Components\CheckboxList::make('da_cancellare')
                        ->label('Seleziona le immagini da rimuovere')
                        ->options(function () {
                            $imgs = $this->record->images ?? [];
                            return collect($imgs)->mapWithKeys(fn ($path) => [$path => basename($path)]);
                        })
                        ->columns(2)
                        ->gridDirection('row')
                        ->bulkToggleable()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $record = $this->record;
                    $imgs   = is_array($record->images) ? $record->images : [];

                    $toDelete = $data['da_cancellare'] ?? [];
                    if (! is_array($toDelete) || empty($toDelete)) {
                        return;
                    }

                    // 1) cancella i file dal disco
                    foreach ($toDelete as $path) {
                        if ($path && Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                    }

                    // 2) aggiorna l'array immagini nel DB
                    $record->images = array_values(array_diff($imgs, $toDelete));
                    $record->save();

                    // 3) notifica + refresh del form
                    Notification::make()
                        ->title('Immagini rimosse correttamente.')
                        ->success()
                        ->send();

                    $this->fillForm(); // ricarica i dati nel form
                }),
        ];
    }
}
