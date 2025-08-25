<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMaintenance
{
    public function handle(Request $request, Closure $next)
  {
        $file = storage_path('framework/maintenance_mode');

        // استثناء رابط toggle-maintenance
        if (file_exists($file) && !$request->is('toggle-maintenance')) {
            return response()->view('maintenance'); // صفحة التطوير
        }

        return $next($request);
    }
}
