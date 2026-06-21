<?php

namespace App\Filament\Widgets;

use App\Models\WorkOrder;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class WorkOrderCreationTrendWidget extends ChartWidget
{
    protected ?string $heading = 'Work Orders Created (Last 30 Days)';

    protected ?string $pollingInterval = '60s';

    protected static ?int $sort = 30;

    protected function getData(): array
    {
        $data = Trend::model(WorkOrder::class)
            ->between(
                start: now()->subDays(29)->startOfDay(),
                end: now()->endOfDay(),
            )->perDay()
            ->count();

        return [
            'datasets' => [[
                'label' => 'Work Orders',
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
