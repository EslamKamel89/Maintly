<?php

namespace App\Filament\Resources\WorkOrders;

use App\Filament\Resources\WorkOrders\Pages\CreateWorkOrder;
use App\Filament\Resources\WorkOrders\Pages\EditWorkOrder;
use App\Filament\Resources\WorkOrders\Pages\ListWorkOrders;
use App\Filament\Resources\WorkOrders\Pages\ViewWorkOrder;
use App\Filament\Resources\WorkOrders\RelationManagers\WorkOrderAttachmentsRelationManager;
use App\Filament\Resources\WorkOrders\Schemas\WorkOrderForm;
use App\Filament\Resources\WorkOrders\Schemas\WorkOrderInfolist;
use App\Filament\Resources\WorkOrders\Tables\WorkOrdersTable;
use App\Models\User;
use App\Models\WorkOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

class WorkOrderResource extends Resource {
    protected static ?string $model = WorkOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocument;

    protected static string|UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema {
        return WorkOrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema {
        return WorkOrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table {
        return WorkOrdersTable::configure($table);
    }

    public static function getRelations(): array {
        return [
            WorkOrderAttachmentsRelationManager::class,
        ];
    }

    public static function getPages(): array {
        return [
            'index' => ListWorkOrders::route('/'),
            'create' => CreateWorkOrder::route('/create'),
            'view' => ViewWorkOrder::route('/{record}'),
            'edit' => EditWorkOrder::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function shouldRegisterNavigation(): bool {
        return auth()->check();
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
