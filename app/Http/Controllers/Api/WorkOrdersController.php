<?php

namespace App\Http\Controllers\Api;

use App\Enums\WorkOrderStatus;
use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class WorkOrdersController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $workOrders = WorkOrder::query()
            ->with([
                'customer:id,company_name',
                'location:id,name',
            ])
            ->where(function (Builder $query) {
                $query->whereIn('status', [WorkOrderStatus::Assigned, WorkOrderStatus::InProgress])
                    ->orWhere(function (Builder $query) {
                        $query->where('status', WorkOrderStatus::Completed)
                            ->whereBetween('completed_at', [now()->subDay(), now()]);
                    });
            });
        if ($user->isTechnician()) {
            $workOrders->whereHas('assignments', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        return response()->json($workOrders->get());
    }

    public function show(Request $request, WorkOrder $workOrder)
    {
        $workOrder->load([
            'customer',
            'location',
            'creator',
            'assets',
            'technicians',
            'comments.user',
            'attachments.uploader',
        ]);

        return response()->json($workOrder);
    }

    public function complete(Request $request, WorkOrder $workOrder)
    {
        $workOrder->update([
            'status' => WorkOrderStatus::Completed,
            'completed_at' => now(),
        ]);

        return response()->json($workOrder);
    }
}
