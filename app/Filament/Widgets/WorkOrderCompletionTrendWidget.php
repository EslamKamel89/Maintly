<?php

namespace App\Filament\Widgets;

use App\Enums\WorkOrderStatus;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class WorkOrderCompletionTrendWidget extends ChartWidget
{
    protected ?string $heading = 'Completed Work Orders (Last 30 Days)';

    protected ?string $pollingInterval = '60s';

    protected static ?int $sort = 40;

    protected function getData(): array
    {
        $data = Trend::query(
            WorkOrder::query()
                ->whereNotNull('completed_at')
                ->where('status', WorkOrderStatus::Completed)
        )->dateColumn('completed_at')
            ->between(
                start: now()->subDays(29)->startOfDay(),
                end: now()->endOfDay(),
            )->perDay()
            ->count();

        return [
            'datasets' => [[
                'label' => 'Completed Work Orders',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                'borderRadius' => 6,
                'maxBarThickness' => 20,
            ]],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M d')),

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
