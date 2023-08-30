<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use App\Models\State;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use App\Filament\Resources\UserResource;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use BezhanSalleh\FilamentLanguageSwitch\FilamentLanguageSwitchPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            //==========Configuraciones de Autenticacion==========
            ->login()
            ->registration()
            ->profile() //mostrar la edicion del perfil
            ->userMenuItems([ //editar el menu derecho de usuarios
                'profile' => MenuItem::make()->label('Perfil'),
                'logout' => MenuItem::make()->label('Cerrar Sesión'),
            ])
            
            //==========Coniguraciones de Marca==========
            ->colors([ 
                'primary' => '#F1613F',
                'secondary' => '#0A060E',
            ])
            ->font('Poppins') // Cambiar fuente de letras
            ->favicon(asset('images/favicon.png')) //Agregar icono favicon
            //==========Configuraciones de Navegacion==========
            ->path('') 
            ->navigationGroups([
                'Administración',
                'Ajustes',
                'Usuarios y Permisos',
            ])
            ->sidebarCollapsibleOnDesktop() // Plegar barra lateral en pantallas web
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources') //genera navegaciones de recursos automaticamente
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages') //genera navegaciones de paginas automaticamente
            ->pages([
                Pages\Dashboard::class, 
            ])
            //==========Configuraciones de Plugins==========
            ->plugins([
                FilamentLanguageSwitchPlugin::make()
            ])
            //==========Otras Configuraciones==========
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
