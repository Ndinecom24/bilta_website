<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CookieConsent;

class CookieConsentController extends Controller
{
    public function store(Request $request)
    {
        CookieConsent::create([
            'ip_address' => $request->ip(),
            'analytics' => $request->input('analytics', false),
            'marketing' => $request->input('marketing', false),
            'consent_given_at' => now(),
        ]);

        return response()->json(['status' => 'ok']);
    }
}
