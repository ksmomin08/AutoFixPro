<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Review;

class PageController extends Controller
{
    public function home()
    {
        $reviews = Review::where('is_visible', true)->latest()->get();
        return view('home', compact('reviews'));
    }

    public function about()
    {
        return view('about');
    }

    public function services()
    {
        return view('services');
    }
}
