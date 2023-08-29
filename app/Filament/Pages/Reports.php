<?php

namespace App\Filament\Pages;

use App\Models\Country;
use Filament\Pages\Page;
use App\Filament\Widgets\StatsOverviewWidget;

class Reports extends Page
{
    protected static ?string $title = 'Reportes';

    protected static ?string $navigationIcon = 'heroicon-s-document-chart-bar';

    protected static ?string $slug = 'reportes';

    protected ?string $heading = 'Reportes de la Empresa';

    protected ?string $subheading = 'Repotes estadisticos en general';

    protected static string $view = 'filament.pages.reports';

    protected static bool $shouldRegisterNavigation = false;
}
