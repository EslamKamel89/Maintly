<?php

namespace App\Filament\Resources\WorkOrderAttachments\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkOrderAttachmentForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Attachment Information')
                    ->schema([
                        FileUpload::make('attachment')
                            ->label('Attachment')
                            ->disk('public')
                            ->required()
                            ->downloadable()
                            ->openable(),
                        Hidden::make('work_order_id')
                            ->default(fn() => request()->route('work_order')),
                    ]),
            ])
            ->columns(1);
    }
}
