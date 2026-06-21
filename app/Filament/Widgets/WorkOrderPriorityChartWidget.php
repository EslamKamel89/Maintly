<?php

namespace App\Filament\Widgets;

use App\Enums\WorkOrderPriority;
use App\Models\WorkOrder;
use Filament\Widgets\ChartWidget;

class WorkOrderPriorityChartWidget extends ChartWidget
{
    protected ?string $heading = 'Work Orders by Priority';

    protected ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 1;

    protected static ?int $sort = 20;

    protected function getData(): array
    {
        return [
            'datasets' => [[
                'label' => 'Work Orders',
                'data' => [
                    WorkOrder::query()
                        ->where('priority', WorkOrderPriority::Low)
                        ->count(),

                    WorkOrder::query()
                        ->where('priority', WorkOrderPriority::Medium)
                        ->count(),

                    WorkOrder::query()
                        ->where('priority', WorkOrderPriority::High)
                        ->count(),

                    WorkOrder::query()
                        ->where('priority', WorkOrderPriority::Critical)
                        ->count(),
                ],
                'backgroundColor' => [
                    '#9CA3AF', // Low
                    '#3B82F6', // Medium
                    '#F59E0B', // High
                    '#EF4444', // Critical
                ],
                'borderRadius' => 6,
                'borderSkipped' => false,
                'maxBarThickness' => 50,
            ]],
            'labels' => [
                'Low',
                'Medium',
                'High',
                'Critical',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
