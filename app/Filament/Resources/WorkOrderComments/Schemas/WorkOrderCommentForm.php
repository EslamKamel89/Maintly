<?php

namespace App\Filament\Resources\WorkOrderComments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WorkOrderCommentForm
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
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
