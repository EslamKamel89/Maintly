<?php

namespace App\Filament\Resources\WorkOrderComments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WorkOrderCommentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('organization.name')
                    ->label('Organization'),
                TextEntry::make('workOrder.title')
                    ->label('Work order'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('comment')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
