<?php

namespace App\Filament\Resources\WorkOrders\RelationManagers;

use App\Filament\Resources\WorkOrderComments\WorkOrderCommentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class WorkOrderCommentsRelationManager extends RelationManager {
    protected static string $relationship = 'comments';
    protected static ?string $title = 'Comments';
    protected static ?string $relatedResource = WorkOrderCommentResource::class;

    public function table(Table $table): Table {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
