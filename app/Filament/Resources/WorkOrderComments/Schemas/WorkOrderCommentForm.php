<?php

namespace App\Filament\Resources\WorkOrderComments\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkOrderCommentForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Comment Information')
                    ->schema([
                        Textarea::make('comment')
                            ->label('Comment')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),

                        Hidden::make('work_order_id')
                            ->default(
                                fn() => request()->route('work_order')
                            ),
                    ]),
            ])
            ->columns(1);
    }
}
