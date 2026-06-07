<?php

namespace App\Enums;


enum WorkOrderPriority: string {
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
    case Critical = 'critical';
}
