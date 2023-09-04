<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Country;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeeStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {   
        $countries = Country::all()->count();
        $country1 = Country::find(1001);
        $country2 = Country::find(1002);
        $country3 = Country::find(1003);

        return [
            Stat::make('Todos los Empleados', $countries),
            Stat::make($country1?->name.' Empleados', $country1?->employees->count()),
            Stat::make($country2?->name.' Empleados', $country2?->employees->count()),
            Stat::make($country3?->name.' Empleados', $country3?->employees->count()),
        ];
    }
}
