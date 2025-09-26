<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livestream;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LivestreamController extends Controller
{
    /**
     * Show the create/manage livestream form.
     */
    public function create()
    {
        $livestream = Livestream::orderByDesc('is_live')
            ->orderByDesc('scheduled_at')
            ->orderByDesc('created_at')
            ->first();

        return Inertia::render('admin/Livestreams/Create', [
            'livestream' => $livestream,
        ]);
    }

    /**
     * Store or update the livestream configuration.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:2048'],
            'is_live' => ['nullable', 'boolean'],
            'scheduled_at' => ['nullable', 'date'],
            'platform' => ['nullable', 'in:facebook'],
        ]);

        // Default platform to facebook
        $validated['platform'] = $validated['platform'] ?? 'facebook';
        $validated['is_live'] = (bool)($validated['is_live'] ?? false);

        // Upsert the latest livestream record
        $livestream = Livestream::orderByDesc('created_at')->first();
        if ($livestream) {
            $livestream->update($validated);
        } else {
            $livestream = Livestream::create($validated);
        }

        return redirect()->route('admin.livestreams.create')
            ->with('success', 'Livestream saved successfully.');
    }
}