<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use View;

class ShareCompareCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $compareCookie = $request->cookie('compare_list');
        $compareCount = 0;
        if ($compareCookie) {
            try {
                $compareList = json_decode($compareCookie, true);
                if (is_array($compareList)) {
                    $compareCount = count($compareList);
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        View::share('compareCount', $compareCount);
        return $next($request);
    }
}
