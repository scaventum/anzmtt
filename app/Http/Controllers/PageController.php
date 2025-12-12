<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    public function show()
    {
        return Inertia::render('Page', [
            'title' => request()->path()
        ]);
    }
}
