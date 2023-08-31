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
        $country1 = Country::where('name','Germany')->withCount('employees')->first();
        $country2 = Country::where('name','Denmark')->withCount('employees')->first();
        $country3 = Country::where('name','Nauru')->withCount('employees')->first();

        return [
            Stat::make('Todos los Empleados', $countries),
            Stat::make($country1->name.' Empleados',$country1->employees_count),
            Stat::make($country2->name.' Empleados',$country2->employees_count),
            Stat::make($country3->name.' Empleados',$country3->employees_count),
        ];
    }
}
