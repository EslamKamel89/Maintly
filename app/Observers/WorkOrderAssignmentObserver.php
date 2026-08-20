<?php

namespace App\Observers;

use App\Enums\WorkOrderStatus;
use App\Models\WorkOrderAssignment;
use App\Services\FirebaseNotificationService;

class WorkOrderAssignmentObserver
{
    public function created(
        WorkOrderAssignment $assignment,
    ): void {
        $notifications = app(FirebaseNotificationService::class);
        $assignment->loadMissing([
            'workOrder',
            'technician',
        ]);

        $workOrder = $assignment->workOrder;
        $technician = $assignment->technician;

        if (! $workOrder || ! $technician) {
            return;
        }

        if (! in_array($workOrder->status, [
            WorkOrderStatus::Assigned,
            WorkOrderStatus::InProgress,
            WorkOrderStatus::Completed,
        ], true)) {
            return;
        }

        if (! is_string($technician->fcm_token) || trim($technician->fcm_token) === '') {
            return;
        }

        [$title, $content] = match ($workOrder->status) {
            WorkOrderStatus::Assigned => [
                'Work Order Assigned',
                'You have been assigned a new work order.',
            ],

            WorkOrderStatus::InProgress => [
                'Work Order In Progress',
                'A work order assigned to you is now in progress.',
            ],

            WorkOrderStatus::Completed => [
                'Work Order Completed',
                'A work order assigned to you has been completed.',
            ],

            default => throw new \LogicException('Unsupported notification status.'),
        };

        $notifications->sendToTokens(
            tokens: [$technician->fcm_token],
            notificationId: "work-order-{$workOrder->id}-{$workOrder->status->value}",
            routeName: '/workOrderScreen',
            title: $title,
            content: $content,
            payload: [
                'work_order_id' => $workOrder->id,
            ],
        );
    }
}
