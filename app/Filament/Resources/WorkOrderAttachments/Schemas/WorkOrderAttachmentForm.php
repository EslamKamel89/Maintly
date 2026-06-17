<?php

namespace App\Filament\Resources\WorkOrderAttachments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WorkOrderAttachmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('work_order_id')
                    ->relationship('workOrder', 'title')
                    ->required(),
                TextInput::make('uploaded_by')
                    ->required()
                    ->numeric(),
                TextInput::make('path')
                    ->required(),
                TextInput::make('file_name')
                    ->required(),
                TextInput::make('mime_type')
                    ->required(),
                TextInput::make('file_size')
                    ->required()
                    ->numeric(),
            ]);
    }
}
