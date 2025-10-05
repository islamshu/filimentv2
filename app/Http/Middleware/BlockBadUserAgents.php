<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockBadUserAgents
{
    public function handle(Request $request, Closure $next)
    {
        
        // قائمة البوتات أو الـ user agents المشبوهة
        $blockedAgents = [
            'python-requests',
            'curl',
            'HttpClient',
            'bot',
            'TelegramBot',
            'TwitterBot',
            'SemrushBot',
            'AhrefsBot',
            'MJ12bot',
            'crawler',
            'spider',
            'scrapy',
        ];

        $userAgent = $request->header('User-Agent', '');

        foreach ($blockedAgents as $agent) {
            if (stripos($userAgent, $agent) !== false) {

                // تسجيل المحاولة في log (اختياري)
                \Log::warning('🚫 Blocked suspicious bot request', [
                    'ip' => $request->ip(),
                    'user_agent' => $userAgent,
                    'path' => $request->path(),
                ]);

                abort(403, 'Access Denied - Bot Detected');
            }
        }

        return $next($request);
    }
}
