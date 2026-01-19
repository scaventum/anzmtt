<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::to(['info@anzmtt.org', 'ryan.djoenaidi@gmail.com'])
            ->send(new ContactMail($validated));

        return back()->with('success', 'Email sent successfully.');
    }
}
