<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkOrderComment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_order_id' => ['required', 'exists:work_orders,id'],
            'comment' => ['required', 'string'],
        ]);
        $comment = WorkOrderComment::create([
            'work_order_id' => $validated['work_order_id'],
            'user_id' => $request->user()->id,
            'comment' => $validated['comment'],
        ]);
        $comment->load('user');

        return response()->json($comment, 201);
    }
}
