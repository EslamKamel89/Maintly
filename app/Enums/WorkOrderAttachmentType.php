<?php

namespace App\Enums;

enum WorkOrderAttachmentType: string
{
    case Before = 'before';
    case After = 'after';
    case General = 'general';

    public function getLabel(): string
    {
        return match ($this) {
            self::Before => 'Before',
            self::After => 'After',
            self::General => 'General',
        };
    }
}
