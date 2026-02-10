<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Catalogo';
    protected static ?string $navigationIcon  = 'heroicon-o-cake';
    protected static ?string $navigationLabel = 'Prodotti';
    protected static ?string $pluralModelLabel = 'Prodotti';
    protected static ?string $modelLabel = 'Prodotto';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Dati prodotto')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(120),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(table: Product::class, column: 'slug', ignoreRecord: true)
                    ->maxLength(140),

                Forms\Components\Select::make('categories')
                    ->label('Categorie')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Descrizione')
                    ->rows(4),

                Forms\Components\TextInput::make('price_cents')
                    ->label('Prezzo (cent)')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->required()
                    ->maxLength(50),

                Forms\Components\Toggle::make('is_visible')
                    ->label('Visibile')
                    ->default(true),

                Forms\Components\FileUpload::make('images')
                    ->label('Immagini')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->appendFiles()
                    ->acceptedFileTypes(['image/*'])
                    ->maxSize(4096)
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->getUploadedFileNameForStorageUsing(function ($file): string {
                        $ext  = $file->getClientOriginalExtension();
                        $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        return 'products/' . Str::slug($base) . '-' . Str::random(8) . '.' . $ext;
                    })
                    ->deleteUploadedFileUsing(function (string $filePath): void {
                        if (Storage::disk('public')->exists($filePath)) {
                            Storage::disk('public')->delete($filePath);
                        }
                    })
                    ->imageEditor()
                    ->openable()
                    ->downloadable()
                    ->maxFiles(12)
                    ->hint('Trascina per riordinare — la prima è la cover'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('images')
                ->label('Foto')
                ->disk('public')
                ->getStateUsing(fn ($record) => (is_array($record->images) && count($record->images)) ? $record->images[0] : null)
                ->square()
                ->toggleable(),

            Tables\Columns\TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('categories.name')
                ->label('Categorie')
                ->badge()
                ->searchable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('sku')
                ->label('SKU')
                ->toggleable(),

            Tables\Columns\TextColumn::make('price_cents')
                ->label('Prezzo')
                ->money('EUR', divideBy: 100)
                ->sortable(),

            Tables\Columns\IconColumn::make('is_visible')
                ->label('Visibile')
                ->boolean(),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Aggiornato')
                ->dateTime('d/m/Y H:i'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
