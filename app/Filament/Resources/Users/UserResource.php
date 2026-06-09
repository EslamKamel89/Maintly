<?php

namespace App\Filament\Resources\Users;

use App\Context\OrganizationContext;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Override;
use UnitEnum;

class UserResource extends Resource {
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static string | UnitEnum | null $navigationGroup = 'Administration';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table {

        return UsersTable::configure($table);
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function shouldRegisterNavigation(): bool {
        /** @var User|null $user */
        $user = auth()->user();

        return $user?->isAdmin()
            || $user?->isOwner()
            || $user?->isManager();
    }

    #[Override]
    public static function canAccess(): bool {
        /** @var User|null $user */
        $user = auth()->user();

        return $user?->isAdmin()
            || $user?->isOwner()
            || $user?->isManager();
    }

    #[Override]
    public static function getEloquentQuery(): Builder {
        /** @var User|null $user */
        $user = auth()->user();
        $query = parent::getEloquentQuery();
        if ($user?->isAdmin()) {
            return $query;
        }
        return $query->where('organization_id', OrganizationContext::id());
    }
}
