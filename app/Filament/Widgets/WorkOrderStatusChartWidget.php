<?php

namespace App\Filament\Widgets;

use App\Enums\WorkOrderStatus;
use App\Models\WorkOrder;
use Filament\Widgets\ChartWidget;

class WorkOrderStatusChartWidget extends ChartWidget
{
    protected ?string $heading = 'Work Orders by Status';

    protected ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 1;

    protected static ?int $sort = 10;

    protected function getData(): array
    {
        $statuses = WorkOrderStatus::cases();

        return [
            'datasets' => [
                [
                    'data' => array_map(
                        fn (WorkOrderStatus $status) => WorkOrder::query()
                            ->where('status', $status)
                            ->count(),
                        $statuses,
                    ),

                    'backgroundColor' => [
                        '#6B7280', // Draft
                        '#3B82F6', // Open
                        '#F59E0B', // Assigned
                        '#8B5CF6', // In Progress
                        '#10B981', // Completed
                        '#EF4444', // Cancelled
                    ],

                    'hoverOffset' => 4,
                ],
            ],

            'labels' => array_map(
                fn (WorkOrderStatus $status) => $status->getLabel(),
                $statuses,
            ),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
