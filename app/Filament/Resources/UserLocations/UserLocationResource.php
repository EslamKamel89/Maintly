<?php

namespace App\Filament\Resources\UserLocations;

use App\Filament\Resources\UserLocations\Pages\CreateUserLocation;
use App\Filament\Resources\UserLocations\Pages\EditUserLocation;
use App\Filament\Resources\UserLocations\Pages\ListUserLocations;
use App\Filament\Resources\UserLocations\Pages\ViewUserLocation;
use App\Filament\Resources\UserLocations\Schemas\UserLocationForm;
use App\Filament\Resources\UserLocations\Schemas\UserLocationInfolist;
use App\Filament\Resources\UserLocations\Tables\UserLocationsTable;
use App\Models\User;
use App\Models\UserLocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

class UserLocationResource extends Resource
{
    protected static ?string $model = UserLocation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static ?string $navigationLabel = 'Trace';

    protected static string|UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 45;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return UserLocationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserLocationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserLocationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserLocations::route('/'),
            'create' => CreateUserLocation::route('/create'),
            'view' => ViewUserLocation::route('/{record}'),
            'edit' => EditUserLocation::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function shouldRegisterNavigation(): bool
    {
        /** @var User|null $user */
        $user = auth()->user();

        return $user?->isAdmin()
            || $user?->isOwner()
            || $user?->isManager();
    }

    #[Override]
    public static function canAccess(): bool
    {
        /** @var User|null $user */
        $user = auth()->user();

        return $user?->isAdmin()
            || $user?->isOwner()
            || $user?->isManager();
    }

    #[Override]
    public static function canCreate(): bool
    {
        /** @var User|null $user */
        $user = auth()->user();

        return $user?->isAdmin() ?? false;
    }

    #[Override]
    public static function canEdit($record): bool
    {
        /** @var User|null $user */
        $user = auth()->user();

        return $user?->isAdmin() ?? false;
    }

    #[Override]
    public static function canDelete($record): bool
    {
        /** @var User|null $user */
        $user = auth()->user();

        return $user?->isAdmin() ?? false;
    }
}
