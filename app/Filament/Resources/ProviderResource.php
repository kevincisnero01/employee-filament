<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Provider;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ProviderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProviderResource\RelationManagers;
use App\Filament\Resources\ProviderResource\Pages\EditProvider;
use App\Filament\Resources\ProviderResource\Pages\ListProviders;
use App\Filament\Resources\ProviderResource\Pages\CreateProvider;

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static ?string $slug = 'proveedores';

    protected static ?string $label = 'Proveedores';

    protected static ?string $navigationLabel = 'Proveedores';

    protected static ?string $navigationGroup  = 'Administración';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-s-truck';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Crear Departamento')
                ->schema([
                    TextInput::make('name')
                        ->label('Nombre')
                        ->required()
                    ,TextInput::make('rif')
                        ->label('RIF')
                        ->required()
                    ,TextInput::make('address')
                        ->label('Direccion')
                        ->required()
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
                    ->toggleable()
                    ->searchable()
                ,TextColumn::make('rif')
                    ->label('RIF')
                    ->toggleable()
                ,TextColumn::make('created_at')
                    ->label('FECHA DE CREACIÓN')
                    ->date('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProviders::route('/'),
            'create' => Pages\CreateProvider::route('/create'),
            'edit' => Pages\EditProvider::route('/{record}/edit'),
        ];
    }    
}
