<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'title' => 'ANZMTT - Home'
        ]);
    }

    public function about()
    {
        return Inertia::render('About', [
            'title' => 'ANZMTT - About'
        ]);
    }
}
