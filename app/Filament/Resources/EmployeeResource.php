<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\State;
use App\Models\Country;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Employee;
use Filament\Forms\Form;
use App\Models\Department;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\EmployeeResource\RelationManagers;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $slug = 'empleados';

    protected static ?string $label = 'Empleados';

    protected static ?string $navigationLabel = 'Empleados';

    protected static ?string $navigationGroup  = 'Administración';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-s-identification';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Registrar Empleado')
                    ->schema([
                        Select::make('country_id')
                            ->label('Pais')
                            ->options(Country::pluck('name','id'))
                            ->suffix(City::all()->count())
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set)=> $set('state_id',null))
                            ->required()
                        ,Select::make('state_id')
                            ->label('Estado')
                            ->options(fn (callable $get) =>
                                !empty($get('country_id'))
                                ? State::where('country_id', $get('country_id'))->pluck('name','id')
                                : []
                            )
                            ->suffix(fn (callable $get) => 
                                !empty($get('country_id')) 
                                ? State::where('country_id', $get('country_id'))->count() 
                                : '-'
                            )
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('city_id',null))
                            ->required()
                        ,Select::make('city_id')
                            ->label('Ciudad')
                            ->options(fn (callable $get) =>
                                !empty($get('state_id'))
                                ? City::where('state_id', $get('state_id'))->pluck('name','id')
                                : []
                            )
                            ->suffix(fn (callable $get) => 
                                !empty($get('state_id')) 
                                ? City::where('state_id', $get('state_id'))->count() 
                                : '-'
                            )
                            ->required()
                        ,Select::make('department_id')
                            ->label('Departamento')
                            ->options(Department::pluck('name','id'))
                            ->searchable()
                            ->required()
                        ,TextInput::make('first_name')
                            ->label('Primer Nombre')
                            ->required()
                        ,TextInput::make('last_name')
                            ->label('Primer Apellido')
                            ->required()
                        ,TextInput::make('address')
                            ->label('Direccion')
                            ->required()
                        ,TextInput::make('phone_number')
                            ->label('Numero  de Telefono')
                            ->required()      
                        ,TextInput::make('zip_code')
                            ->label('Código Postal')
                            ->required() 
                        ,DatePicker::make('birth_date')
                            ->label('Fecha de Nacimiento')
                            ->required()
                        ,DatePicker::make('date_hired')
                            ->label('Fecha de Contratado')
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
                ,TextColumn::make('first_name')
                    ->label('NOMBRE')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                ,TextColumn::make('last_name')
                    ->label('APELLIDO')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                ,TextColumn::make('department.name')
                    ->label('DEPARTAMENTO')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                ,TextColumn::make('date_hired')
                    ->label('CONTRATADO')
                    ->date('d/m/Y')
                    ->toggleable()
                ,TextColumn::make('created_at')
                    ->label('FECHA DE CREACIÓN')
                    ->date('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                SelectFilter::make('department_id')
                    ->options(Department::pluck('name','id'))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }    
}
