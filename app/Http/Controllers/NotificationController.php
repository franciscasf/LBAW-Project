<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
{
    $notifications = Notification::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('notifications.index', compact('notifications'));
}


    // Marcar uma notificação como lida
    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if (!$notification || $notification->user_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Notificação não encontrada.'], 404);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => 'Notificação marcada como lida.']);
    }

    // Marcar todas as notificações como lidas
    public function markAllAsRead()
    {
        Auth::user()
            ->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => 'Todas as notificações foram marcadas como lidas.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:user,user_id',
            'question_id' => 'nullable|integer|exists:question,question_id',
            'answer_id' => 'nullable|integer|exists:answer,answer_id',
            'responder_id' => 'required|integer|exists:user,user_id',
            'message' => 'required|string|max:100',
        ]);

        $notification = Notification::create([
            'user_id' => $validated['user_id'],
            'question_id' => $validated['question_id'] ?? null,
            'answer_id' => $validated['answer_id'] ?? null,
            'responder_id' => $validated['responder_id'],
            'created_at' => now(),
            'is_read' => false, 
            'message' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification created successfully.',
            'data' => $notification,
        ], 201);
    }
}
