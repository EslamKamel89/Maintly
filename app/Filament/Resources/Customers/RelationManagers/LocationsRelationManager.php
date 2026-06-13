<?php

namespace App\Filament\Resources\Customers\RelationManagers;

use App\Filament\Resources\Locations\LocationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class LocationsRelationManager extends RelationManager {
    protected static string $relationship = 'locations';

    protected static ?string $relatedResource = LocationResource::class;

    public function table(Table $table): Table {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
