<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\WorkOrderCompletionTrendWidget;
use App\Filament\Widgets\WorkOrderCreationTrendWidget;
use App\Filament\Widgets\WorkOrderPriorityChartWidget;
use App\Filament\Widgets\WorkOrderStatsWidget;
use App\Filament\Widgets\WorkOrderStatusChartWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dashboard')
            ->path('dashboard')
            ->login()
            ->colors([
                'primary' => Color::convertToOklch('#4397cb'),
                'gray' => Color::Slate,
                'info' => Color::Violet,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                WorkOrderStatsWidget::class,
                WorkOrderStatusChartWidget::class,
                WorkOrderPriorityChartWidget::class,
                WorkOrderCreationTrendWidget::class,
                WorkOrderCompletionTrendWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                // InitializeOrganizationContext::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->sidebarCollapsibleOnDesktop(true)
            ->sidebarWidth('fit-content')
            ->spa();
    }
}
