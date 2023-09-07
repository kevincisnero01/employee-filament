<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RoleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RoleResource\RelationManagers;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $slug = "roles";

    protected static ?string $label = "Roles";

    protected static ?string $navigationLabel = 'Roles';

    protected static ?string $navigationGroup  = 'Usuarios y Permisos';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-s-shield-check';

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
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                ,Select::make('permissions')
                    ->label('Permisos Asociados')
                    ->multiple()
                    ->relationship(name: 'permissions', titleAttribute: 'name')
                    ->preload()
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
                    ->label('NOMBRE DE ROL')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                ,TextColumn::make('permissions_count')
                    ->label('PERMISOS')
                    ->counts('permissions')
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
            'index' => Pages\ManageRoles::route('/'),
        ];
    }   
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('name','!=', 'Administrador');
    }

}
