<?php

namespace App\Enums;


enum WorkOrderStatus: string {
    case Draft = 'draft';

    case Open = 'open';

    case Assigned = 'assigned';

    case InProgress = 'in_progress';

    case Completed = 'completed';

    case Cancelled = 'cancelled';
}
