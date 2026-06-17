<?php

namespace App\Filament\Resources\WorkOrderAttachments;

use App\Filament\Resources\WorkOrderAttachments\Pages\CreateWorkOrderAttachment;
use App\Filament\Resources\WorkOrderAttachments\Pages\EditWorkOrderAttachment;
use App\Filament\Resources\WorkOrderAttachments\Pages\ListWorkOrderAttachments;
use App\Filament\Resources\WorkOrderAttachments\Pages\ViewWorkOrderAttachment;
use App\Filament\Resources\WorkOrderAttachments\Schemas\WorkOrderAttachmentForm;
use App\Filament\Resources\WorkOrderAttachments\Schemas\WorkOrderAttachmentInfolist;
use App\Filament\Resources\WorkOrderAttachments\Tables\WorkOrderAttachmentsTable;
use App\Models\WorkOrderAttachment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WorkOrderAttachmentResource extends Resource
{
    protected static ?string $model = WorkOrderAttachment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'file_name';

    public static function form(Schema $schema): Schema
    {
        return WorkOrderAttachmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkOrderAttachmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkOrderAttachmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkOrderAttachments::route('/'),
            'create' => CreateWorkOrderAttachment::route('/create'),
            'view' => ViewWorkOrderAttachment::route('/{record}'),
            'edit' => EditWorkOrderAttachment::route('/{record}/edit'),
        ];
    }
}
