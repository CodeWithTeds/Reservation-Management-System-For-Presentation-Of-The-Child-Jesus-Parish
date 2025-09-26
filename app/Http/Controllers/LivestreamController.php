<?php

namespace App\Http\Controllers;

use App\Models\Livestream;
use Inertia\Inertia;
use Inertia\Response;

class LivestreamController extends Controller
{
    public function show(): Response
    {
        // Get the latest livestream marked as live or, if none live, the latest scheduled/created
        $livestream = Livestream::orderByDesc('is_live')
            ->orderByDesc('scheduled_at')
            ->orderByDesc('created_at')
            ->first();

        return Inertia::render('Livestream', [
            'livestream' => $livestream ? [
                'id' => $livestream->id,
                'title' => $livestream->title,
                'platform' => $livestream->platform,
                'url' => $livestream->url,
                'is_live' => (bool) $livestream->is_live,
                'scheduled_at' => optional($livestream->scheduled_at)?->toDateTimeString(),
            ] : null,
        ]);
    }
}