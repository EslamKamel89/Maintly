<?php

namespace App\Observers;

use App\Enums\WorkOrderStatus;
use App\Models\WorkOrder;
use App\Services\FirebaseNotificationService;

class WorkOrderObserver
{
    public function updated(
        WorkOrder $workOrder,
        FirebaseNotificationService $notifications,
    ): void {
        if (! $workOrder->wasChanged('status')) {
            return;
        }

        /** @var WorkOrderStatus|null $status */
        $status = $workOrder->status;

        if (! in_array($status, [
            WorkOrderStatus::Assigned,
            WorkOrderStatus::InProgress,
            WorkOrderStatus::Completed,
        ], true)) {
            return;
        }

        $tokens = $workOrder->technicians()
            ->whereNotNull('fcm_token')
            ->pluck('fcm_token')
            ->filter(fn (mixed $token): bool => is_string($token) && trim($token) !== '')
            ->unique()
            ->values()
            ->all();

        if ($tokens === []) {
            return;
        }

        [$title, $content] = match ($status) {
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
            tokens: $tokens,
            notificationId: "work-order-{$workOrder->id}-{$status->value}",
            routeName: '/workOrderScreen',
            title: $title,
            content: $content,
            payload: [
                'work_order_id' => $workOrder->id,
            ],
        );
    }
}
