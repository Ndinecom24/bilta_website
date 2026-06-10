<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Bilta\Click;


use donatj\UserAgent\UserAgentParser;

use Stevebauman\Location\Facades\Location;

class TrackClicks
{
    public function handle(Request $request, Closure $next)
    {


        if ($request->is('bilta/zadmin/*')) {
            return $next($request); // skip admin pages
        }

        // Skip bots and crawlers
        $userAgent = strtolower($request->userAgent() ?? '');
        $botPatterns = ['bot', 'crawler', 'spider', 'slurp', 'facebookexternalhit', 'mediapartners', 'googlebot', 'bingbot', 'yandex', 'baidu', 'semrush', 'ahref', 'curl', 'wget', 'python', 'headless'];
        foreach ($botPatterns as $pattern) {
            if (str_contains($userAgent, $pattern)) {
                return $next($request);
            }
        }

        // Only track GET requests (to avoid logging form posts, etc.)
        if ($request->isMethod('get') && !$request->ajax() && !$request->expectsJson()) {
            try {
         
                $location = Location::get($request->ip());

            


                $parser = new UserAgentParser();
                $result = $parser->parse($request->userAgent());
                
                $browserName = $result->browser() ?? 'Unknown';
                $platform = $result->platform() ?? 'Unknown';
                
                // Determine device type (basic heuristic)
                $ua = strtolower($platform);
                $deviceType = str_contains($ua, 'android') || str_contains($ua, 'ios') ? 'Mobile' : 'Desktop';

                Click::create([
                    'url' => \Illuminate\Support\Str::limit($request->fullUrl(), 2000, ''),
                    'page_name' => \Route::currentRouteName() ?? 'Unknown',
                    'method' => $request->method(),
                    'referrer' => \Illuminate\Support\Str::limit($request->headers->get('referer'), 2000, ''),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),

                    'device_type' => $deviceType,
                    'platform' =>$platform,
                    'browser' => $browserName,

                    'user_id' => auth()->id(),
                    'session_id' => $request->session()->getId(),

                    'country' => $location->countryName ?? null,
'city' => $location->cityName ?? null,
'region' => $location->regionName ?? null,
'timezone' => $location->timezone ?? null,
'latitude' => $location->latitude ?? null,
'longitude' => $location->longitude ?? null

                ]);
            } catch (\Exception $e) {
                \Log::warning("Click tracking failed: " . $e->getMessage());
            }
        }

        return $next($request);
    }
}
