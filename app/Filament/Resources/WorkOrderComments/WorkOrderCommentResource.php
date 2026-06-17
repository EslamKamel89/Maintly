<?php

namespace App\Filament\Resources\WorkOrderComments;

use App\Filament\Resources\WorkOrderComments\Pages\CreateWorkOrderComment;
use App\Filament\Resources\WorkOrderComments\Pages\EditWorkOrderComment;
use App\Filament\Resources\WorkOrderComments\Pages\ListWorkOrderComments;
use App\Filament\Resources\WorkOrderComments\Pages\ViewWorkOrderComment;
use App\Filament\Resources\WorkOrderComments\Schemas\WorkOrderCommentForm;
use App\Filament\Resources\WorkOrderComments\Schemas\WorkOrderCommentInfolist;
use App\Filament\Resources\WorkOrderComments\Tables\WorkOrderCommentsTable;
use App\Filament\Resources\WorkOrders\WorkOrderResource;
use App\Models\User;
use App\Models\WorkOrderComment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;

class WorkOrderCommentResource extends Resource {
    protected static ?string $model = WorkOrderComment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = WorkOrderResource::class;

    public static function form(Schema $schema): Schema {
        return WorkOrderCommentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema {
        return WorkOrderCommentInfolist::configure($schema);
    }

    public static function table(Table $table): Table {
        return WorkOrderCommentsTable::configure($table);
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => ListWorkOrderComments::route('/'),
            'create' => CreateWorkOrderComment::route('/create'),
            'view' => ViewWorkOrderComment::route('/{record}'),
            'edit' => EditWorkOrderComment::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function shouldRegisterNavigation(): bool {
        return false;
    }

    #[Override]
    public static function canCreate(): bool {
        /** @var User|null $user */
        $user = auth()->user();

        return !$user?->isTechnician();
    }

    #[Override]
    public static function canEdit($record): bool {
        /** @var User|null $user */
        $user = auth()->user();

        return !$user?->isTechnician();
    }

    #[Override]
    public static function canDelete($record): bool {
        /** @var User|null $user */
        $user = auth()->user();

        return !$user?->isTechnician();
    }
}
