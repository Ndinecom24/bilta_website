<?php

namespace App\Http\Controllers;

use App\Models\Bilta\Testimonial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function clearCache()
    {
        try {
            Artisan::call('optimize:clear');
            if (request()->expectsJson()) {
                return response()->json(['success' => true]);
            }

            return back()->with('success', 'System cache cleared successfully.');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }

            return back()->with('error', 'Failed to clear system cache: ' . $e->getMessage());
        }
    }


}
