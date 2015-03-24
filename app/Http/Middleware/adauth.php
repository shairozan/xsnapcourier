<?php namespace App\Http\Middleware;

use Closure;
use adLDAP\adLDAP;
use Session;

class adauth {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if( ! Session::get('adauth')){
			return redirect('/login');
		}  else {
			//This allows it to continue processing
			return $next($request);
		}
	}

}
