<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Supplie;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SupplieResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SupplieResource\RelationManagers;

class SupplieResource extends Resource
{
    protected static ?string $model = Supplie::class;

    protected static ?string $slug = "suministros";

    protected static ?string $label = "Suministros";

    protected static ?string $navigationLabel = 'Suministros';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-s-rectangle-stack';

    protected static ?string $navigationGroup  = 'Administración';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Crear Suministro')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->placeholder('Ingrese el nombre de proveedor')
                            ->required()
                            ->maxLength(255)
                        ,FileUpload::make('image')
                            ->label('Imagen (Solo PNG)')
                            ->image()->preserveFilenames()
                            ->required()
                        ,TextInput::make('phone')
                            ->label('Telefono')
                            ->placeholder('Ej: 0412-1234567')
                            ->tel()
                            ->maxLength(13)
                        ,FileUpload::make('contract')
                            ->label('Contrato (Solo PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->preserveFilenames()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                ,TextColumn::make('name')
                    ->label('NOMBRE')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                ,ImageColumn::make('image')
                    ->label('Imagen')
                    ->circular()
                    ->toggleable()
                ,TextColumn::make('contract')
                    ->label('Contrato')
                    ->toggleable()
                ,TextColumn::make('created_at')
                    ->label('FECHA DE CREACIÓN')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupplies::route('/'),
            'create' => Pages\CreateSupplie::route('/create'),
            'edit' => Pages\EditSupplie::route('/{record}/edit'),
        ];
    }    
}
