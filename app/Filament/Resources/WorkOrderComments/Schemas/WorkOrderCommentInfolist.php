<?php

namespace App\Filament\Resources\WorkOrderComments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkOrderCommentInfolist {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Comment Information')
                    ->schema([
                        TextEntry::make('organization.name')
                            ->label('Organization')
                            ->visible(
                                fn() => auth()->user()?->isAdmin()
                            ),

                        TextEntry::make('workOrder.title')
                            ->label('Work Order'),

                        TextEntry::make('user.name')
                            ->label('Author'),

                        TextEntry::make('comment')
                            ->label('Comment')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Audit Information')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created')
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
