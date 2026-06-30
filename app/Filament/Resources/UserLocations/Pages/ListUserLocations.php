<?php

namespace App\Filament\Resources\UserLocations\Pages;

use App\Filament\Resources\UserLocations\UserLocationResource;
use App\Models\UserLocation;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListUserLocations extends ListRecords
{
    protected static string $resource = UserLocationResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];
        if (auth()->user()?->isAdmin()) {
            $actions[] = CreateAction::make();
        }
        if (! auth()->user()?->isTechnician()) {
            $actions[] = Action::make('cleanup')
                ->label('Delete Traces Older Than 30 Days')
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()->action(function () {
                    $deleted = UserLocation::query()
                        ->where('created_at', '<', now()->subDays(30))
                        ->delete();
                    Notification::make()
                        ->title("Deleted {$deleted} trace records")
                        ->success()
                        ->send();
                });
        }

        return $actions;
    }
}
