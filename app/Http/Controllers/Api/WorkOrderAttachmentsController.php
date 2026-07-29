<?php

namespace App\Http\Controllers\Api;

use App\Enums\WorkOrderAttachmentType;
use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\WorkOrderAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class WorkOrderAttachmentsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_order_id' => ['required', 'exists:work_orders,id'],
            'type' => ['required', Rule::in(array_column(WorkOrderAttachmentType::cases(), 'value'))],
            'notes' => ['nullable', 'string'],
            'attachment' => ['required', 'image'],
        ]);
        $workOrder = WorkOrder::findOrFail($validated['work_order_id']);
        $path = $request->file('attachment')->store(
            sprintf(
                'organizations/%d/work-orders/%d',
                $workOrder->organization_id,
                $workOrder->id,
            ),
            'public',
        );
        $attachment = WorkOrderAttachment::create([
            'organization_id' => $workOrder->organization_id,
            'work_order_id' => $workOrder->id,
            'uploaded_by' => $request->user()->id,
            'type' => $validated['type'],
            'notes' => $validated['notes'] ?? null,
            'path' => $path,
            'file_name' => basename($path),
            'mime_type' => Storage::disk('public')->mimeType($path),
            'file_size' => Storage::disk('public')->size($path),
        ]);
        $attachment->load('uploader');

        return response()->json($attachment, 201);
    }
}
