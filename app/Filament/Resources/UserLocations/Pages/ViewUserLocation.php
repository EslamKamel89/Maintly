<?php

namespace App\Filament\Resources\UserLocations\Pages;

use App\Filament\Resources\UserLocations\UserLocationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUserLocation extends ViewRecord
{
    protected static string $resource = UserLocationResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        if (auth()->user()?->isAdmin()) {
            $actions[] = EditAction::make();
            $actions[] = DeleteAction::make();
        }

        return $actions;
    }
}
