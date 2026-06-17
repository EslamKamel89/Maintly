<?php

namespace App\Filament\Resources\WorkOrderAttachments;

use App\Filament\Resources\WorkOrderAttachments\Pages\CreateWorkOrderAttachment;
use App\Filament\Resources\WorkOrderAttachments\Pages\EditWorkOrderAttachment;
use App\Filament\Resources\WorkOrderAttachments\Pages\ListWorkOrderAttachments;
use App\Filament\Resources\WorkOrderAttachments\Pages\ViewWorkOrderAttachment;
use App\Filament\Resources\WorkOrderAttachments\Schemas\WorkOrderAttachmentForm;
use App\Filament\Resources\WorkOrderAttachments\Schemas\WorkOrderAttachmentInfolist;
use App\Filament\Resources\WorkOrderAttachments\Tables\WorkOrderAttachmentsTable;
use App\Filament\Resources\WorkOrders\WorkOrderResource;
use App\Models\User;
use App\Models\WorkOrderAttachment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

class WorkOrderAttachmentResource extends Resource {
    protected static ?string $model = WorkOrderAttachment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Operations';
    protected static ?string $parentResource = WorkOrderResource::class;
    protected static ?int $navigationSort = 50;

    public static function form(Schema $schema): Schema {
        return WorkOrderAttachmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema {
        return WorkOrderAttachmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table {
        return WorkOrderAttachmentsTable::configure($table);
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => ListWorkOrderAttachments::route('/'),
            'create' => CreateWorkOrderAttachment::route('/create'),
            'view' => ViewWorkOrderAttachment::route('/{record}'),
            'edit' => EditWorkOrderAttachment::route('/{record}/edit'),
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
        return false;
    }

    #[Override]
    public static function canDelete($record): bool {
        /** @var User|null $user */
        $user = auth()->user();

        return !$user?->isTechnician();
    }
}
