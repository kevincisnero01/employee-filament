<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = "usuarios";

    protected static ?string $label = "Usuarios";

    protected static ?string $navigationLabel = 'Usuarios';

    protected static ?string $navigationGroup  = 'Usuarios y Permisos';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(50)
                ,TextInput::make('email')
                    ->label('Correo')
                    ->email()
                    ->required()
                    ->maxLength(50)
                ,Select::make('roles')
                    ->label('Roles de Usuario')
                    ->relationship(name: 'roles', titleAttribute: 'name')
                    ->preload()
                ,TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn (Page  $livewire):bool => $livewire instanceof  CreateRecord)
                    ->minLength(8)
                    ->maxLength(50)
                    ->same('passwordConfirmation')
                    ->dehydrated(fn ($state) => filled ($state))
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ,TextInput::make('passwordConfirmation')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn (Page  $livewire):bool => $livewire instanceof  CreateRecord)
                    ->minLength(8)
                    ->maxLength(50)
                    ->dehydrated(false)
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
                ,TextColumn::make('email')
                    ->label('Correo')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                ,TextColumn::make('roles.name')
                    ->label('Rol')
                    ->sortable()
                    ->searchable()
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
            'index' => Pages\ManageUsers::route('/'),
        ];
    }    
}
