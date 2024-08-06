<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFrontendRequestsAreStateful
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return (new Pipeline(app()))->send($request)->through(
            static::fromFrontend($request) ? $this->frontendMiddleware() : []
        )->then(function ($request) use ($next){
            return $next($request);
        });
    }

    public static function fromFrontend ($request){
        $domain = $request ->headers->get('referer') ?: $request->headers->get('origin');

        if(is_null($domain)){
            return false;
        }

        $domain = Str::replaceFirst('https://', '', $domain);
        $domain = Str::replaceFirst('http://', '', $domain);
        $domain = Str::endsWith($domain, '/')? $domain : "{$domain}/";
        
        $stateful = array_filter(config('sanctum_stateful', []));

        Log::debug("xx", [$domain, $stateful]);

        return Str::is(Collection::make($stateful)->map(function ($uri){
            return trim($uri). "/*";
        })->all(),$domain);
    }

}
