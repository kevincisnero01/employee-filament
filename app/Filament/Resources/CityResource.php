<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
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
use Illuminate\Contracts\Support\Htmlable;


class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $slug = 'ciudades';

    protected static ?string $label = 'Ciudades';

    protected static ?string $navigationLabel = 'Ciudades';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup  = 'Ajustes';

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $activeNavigationIcon = 'heroicon-s-map-pin';



    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Crear Ciudad')
                ->schema([
                    Select::make('state_id')
                        ->label('Estado')
                        ->options(State::pluck('name','id'))
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
                ,TextColumn::make('state.name')
                    ->label('ESTADOS')
                    ->sortable()
                    ->searchable()
                    ->toggleable()    
                ,TextColumn::make('name')
                    ->label('NOMBRE')
                    ->sortable()
                    ->toggleable()
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
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }    
}
