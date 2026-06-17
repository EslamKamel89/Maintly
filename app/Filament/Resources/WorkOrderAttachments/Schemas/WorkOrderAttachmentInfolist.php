<?php

namespace App\Filament\Resources\WorkOrderAttachments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WorkOrderAttachmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('organization.name')
                    ->label('Organization'),
                TextEntry::make('workOrder.title')
                    ->label('Work order'),
                TextEntry::make('uploaded_by')
                    ->numeric(),
                TextEntry::make('path'),
                TextEntry::make('file_name'),
                TextEntry::make('mime_type'),
                TextEntry::make('file_size')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
