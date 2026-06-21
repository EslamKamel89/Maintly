<?php

namespace App\Filament\Widgets;

use App\Enums\WorkOrderStatus;
use App\Models\WorkOrder;
use Filament\Schemas\Components\Section;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WorkOrderStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = null;

    protected int|string|array $columnSpan = 'full';

    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        return [
            Section::make('Work Orders Stats')->schema([
                Stat::make('Open', WorkOrder::query()
                    ->where('status', WorkOrderStatus::Open)->count())
                    ->color('info'),
                Stat::make(
                    'Assigned',
                    WorkOrder::query()
                        ->where('status', WorkOrderStatus::Assigned)
                        ->count()
                )->color('warning'),
                Stat::make('In Progress', WorkOrder::query()
                    ->where('status', WorkOrderStatus::InProgress)
                    ->count())->color('primary'),
                Stat::make(
                    'Overdue',
                    WorkOrder::query()
                        ->where('due_at', '<', now())->whereNotIn('status', [WorkOrderStatus::Completed, WorkOrderStatus::Cancelled])->count()
                )->color('danger'),
                Stat::make(
                    'Completed This Month',
                    WorkOrder::query()
                        ->where('status', WorkOrderStatus::Completed)
                        ->whereBetween('completed_at', [
                            now()->startOfMonth(),
                            now()->endOfMonth(),
                        ])
                        ->count()
                )
                    ->color('success'),
            ])->columnSpanFull()->columns([
                'default' => 1,
                'sm' => 2,
                'md' => 3,
                'xl' => 5,

            ])->collapsible(),

        ];
    }
}
