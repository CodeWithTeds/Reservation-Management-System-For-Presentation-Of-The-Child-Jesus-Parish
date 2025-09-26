<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('admin/Notifications/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'message' => ['required','string'],
            'expires_at' => ['nullable','date'],
            'is_active' => ['nullable','boolean'],
        ]);

        $notification = Notification::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'expires_at' => $validated['expires_at'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('admin.notifications.create')
            ->with(['message' => 'Notification created successfully.', 'type' => 'success']);
    }
}