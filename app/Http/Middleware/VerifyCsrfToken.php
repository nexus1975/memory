<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

        protected function excludedRoutes($request)  
        {
            $routes = [
                'ext/geo',
                'ext/upload',
                'ext/saveroute'
            ];

            foreach($routes as $route)
                if ($request->is($route))
                    return true;

                return false;
        }

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */  
        public function handle($request, Closure $next)  {
            if ($this->isReading($request) || $this->excludedRoutes($request) || $this->tokensMatch($request))
            {
                return $this->addCookieToResponse($request, $next($request));
            }

            throw new TokenMismatchException;
        }

}
