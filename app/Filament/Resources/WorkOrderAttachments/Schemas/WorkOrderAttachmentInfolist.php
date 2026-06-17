<?php

namespace App\Filament\Resources\WorkOrderAttachments\Schemas;

use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class WorkOrderAttachmentInfolist {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Attachment Information')
                    ->schema([
                        TextEntry::make('organization.name')
                            ->label('Organization'),

                        TextEntry::make('workOrder.title')
                            ->label('Work Order'),

                        TextEntry::make('uploader.name')
                            ->label('Uploaded By'),

                        TextEntry::make('file_name')
                            ->label('File Name'),

                        TextEntry::make('mime_type')
                            ->label('File Type'),

                        TextEntry::make('file_size')
                            ->label('File Size')
                            ->numeric(),
                    ])
                    ->columns(2),

                Section::make('Storage Information')
                    ->schema([
                        TextEntry::make('path')
                            ->columnSpanFull(),
                        Action::make('download')
                            ->icon('heroicon-o-arrow-down-tray')
                            ->url(
                                fn($record) => Storage::url($record->path)
                            )
                            ->openUrlInNewTab(),
                    ]),

                Section::make('Audit Information')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Uploaded At')
                            ->dateTime()
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2),
            ])
            ->columns(1);
    }
}
