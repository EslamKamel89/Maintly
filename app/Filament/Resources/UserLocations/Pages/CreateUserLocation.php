<?php

namespace App\Filament\Resources\UserLocations\Pages;

use App\Filament\Resources\UserLocations\UserLocationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserLocation extends CreateRecord
{
    protected static string $resource = UserLocationResource::class;
}
