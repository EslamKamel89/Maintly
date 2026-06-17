<?php

namespace App\Enums;


enum WorkOrderStatus: string {
    case Draft = 'draft';

    case Open = 'open';

    case Assigned = 'assigned';

    case InProgress = 'in_progress';

    case Completed = 'completed';

    case Cancelled = 'cancelled';

    public function getLabel(): string {
        return match ($this) {
            self::Draft => 'Draft',
            self::Open => 'Open',
            self::Assigned => 'Assigned',
            self::InProgress => 'In Progress',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }
}
