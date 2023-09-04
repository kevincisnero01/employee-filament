<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\PermissionResource\RelationManagers;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $slug = "permisos";

    protected static ?string $label = "Permisos";

    protected static ?string $navigationLabel = 'Permisos';

    protected static ?string $navigationGroup  = 'Usuarios y Permisos';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-s-key';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre de Rol')
                    ->required()
                    ->unique()
                    ->maxLength(50)
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
                    ->label('NOMBRE DE PERMISO')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                ,TextColumn::make('created_at')
                    ->label('FECHA DE CREACIÓN')
                    ->date('d/m/Y')
                ,TextColumn::make('updated_at')
                    ->label('FECHA DE ACTUALIZACIÓN')
                    ->date('d/m/Y')
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
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePermissions::route('/'),
        ];
    }    
}
