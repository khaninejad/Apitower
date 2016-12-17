<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	  protected $except = [
        'service/*',
    ];
	public function handle($request, Closure $next)
	{
		   if(strpos($request->getRequestUri(), 'service') >= 0)
        {
            return $next($request);
        }
        return parent::handle($request, $next);
	}

}
