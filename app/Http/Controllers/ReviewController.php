<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bike' => 'required|string|max:255',
            'text' => 'required|string',
            'stars' => 'required|integer|min:1|max:5',
        ]);

        // Generate initials
        $words = explode(' ', $validated['name']);
        $initials = '';
        foreach ($words as $w) {
            $initials .= strtoupper(substr($w, 0, 1));
        }
        $initials = substr($initials, 0, 2); // Limit to 2 chars

        Review::create([
            'name' => $validated['name'],
            'bike' => $validated['bike'],
            'text' => $validated['text'],
            'stars' => $validated['stars'],
            'initials' => $initials,
            'is_visible' => true, // Auto-visible for now
        ]);

        return back()->with('success', 'Thank you for your review! It will be visible on the home page shortly.');
    }
}
