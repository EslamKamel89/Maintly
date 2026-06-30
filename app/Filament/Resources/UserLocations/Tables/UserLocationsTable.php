<?php

namespace App\Filament\Resources\UserLocations\Tables;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\UserLocation;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserLocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Technician')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable()
                    ->visible(
                        fn () => auth()->user()?->isAdmin()
                    )
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('coordinates')->state(
                    fn (UserLocation $record) => "{$record->latitude}, {$record->longitude}"
                )->label('Coordinates')
                    ->copyable(),

                TextColumn::make('created_at')
                    ->label('Age')
                    ->since()
                    ->toggleable(),
            ])
            ->stackedOnMobile()
            ->filters([
                SelectFilter::make('organization')
                    ->relationship('organization', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(
                        fn () => auth()->user()?->isAdmin()
                    ),
                Filter::make('time_range')
                    ->label('Time Range')->form([
                        Select::make('range')
                            ->label('Range')
                            ->live()
                            ->options([
                                '1h' => 'Last Hour',
                                '6h' => 'Last 6 Hours',
                                '24h' => 'Last 24 Hours',
                                '7d' => 'Last 7 Days',
                                '30d' => 'Last 30 Days',
                            ]),
                    ])->query(function (Builder $query, array $data): Builder {
                        $range = $data['range'] ?? null;
                        if (blank($range)) {
                            return $query;
                        }
                        $from = match ($range) {
                            '1h' => now()->subHour(),
                            '6h' => now()->subHours(6),
                            '24h' => now()->subDay(),
                            '7d' => now()->subDays(7),
                            '30d' => now()->subDays(30),
                            default => null,
                        };
                        if ($from === null) {
                            return $query;
                        }

                        return $query->where(
                            'created_at',
                            '>=',
                            $from,
                        );
                    })->indicateUsing(function (array $data): ?string {
                        return match ($data['range'] ?? null) {
                            '1h' => 'Last Hour',
                            '6h' => 'Last 6 Hours',
                            '24h' => 'Last 24 Hours',
                            '7d' => 'Last 7 Days',
                            '30d' => 'Last 30 Days',
                            default => null,
                        };
                    }),
                Filter::make('technician')->form([
                    Select::make('user_id')
                        ->label('Technician')
                        ->live()
                        ->searchable()
                        ->preload()
                        ->options(function (callable $get) {
                            $query = User::query()
                                ->where('role', UserRole::Technician)
                                ->orderBy('name');
                            if (auth()->user()?->isAdmin()) {
                                return $query->pluck('name', 'id');
                            }

                            return $query
                                ->where('organization_id', auth()->user()->organization_id)
                                ->pluck('name', 'id');
                        }),
                ])->query(function (Builder $query, array $data) {
                    if (blank($data['user_id'] ?? null)) {
                        return $query;
                    }

                    return $query->where(
                        'user_id',
                        $data['user_id']
                    );
                })->indicateUsing(function ($data) {
                    $userId = $data['user_id'] ?? null;
                    if (! $userId) {
                        return;
                    }

                    return User::query()->findOrFail($userId)->name;
                }),
                Filter::make('latest_only')
                    ->form([
                        Toggle::make('enabled')
                            ->label('Latest Trace Per Technician')
                            ->default(false)
                            ->live(),
                    ])->query(function (Builder $query, array $data) {
                        $enabled = $data['enabled'] ?? false;
                        if (! $enabled) {

                            return $query;
                        }

                        return $query->whereIn('id', UserLocation::query()->selectRaw('MAX(id)')->groupBy('user_id'));

                    })->indicateUsing(function ($data) {
                        $enabled = $data['enabled'] ?? false;
                        if ($enabled) {
                            return 'Latest Trace Per Technician';
                        }
                    }),
            ])
            ->recordActions([
                ViewAction::make(),

                Action::make('map')
                    ->label('Map')
                    ->icon('heroicon-o-map')
                    ->url(
                        fn (UserLocation $record) => sprintf(
                            'https://www.google.com/maps?q=%s,%s',
                            $record->latitude,
                            $record->longitude
                        )
                    )
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(
                        fn () => auth()->user()?->isAdmin()
                    ),
                ]),
            ]);
    }
}
