<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StateResource\Pages;
use App\Filament\Resources\StateResource\RelationManagers;
use App\Models\Country;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static ?string $slug = 'estados';

    protected static ?string $label = 'Estados';

    protected static ?string $navigationLabel = 'Estados';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup  = 'Ajustes';

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Crear Estado')
                    ->schema([
                        Select::make('country_id')
                            ->label('Paises')
                            ->options(Country::pluck('name','id'))
                            ->searchable()
                            ->required()
                        ,TextInput::make('name')
                            ->label('Nombre')
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
                ,TextColumn::make('country.name')
                    ->label('PAIS')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                ,TextColumn::make('name')
                    ->label('NOMBRE')
                    ->sortable()
                    ->searchable()
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
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateState::route('/create'),
            'edit' => Pages\EditState::route('/{record}/edit'),
        ];
    }    
}
