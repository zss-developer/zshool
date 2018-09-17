<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class Language
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $prefered   = $request->getPreferredLanguage(config('app.locales'));
		$raw        = session('locale', $prefered);

		/*
		 * Check available locales
		 */
		$locale     = (in_array($raw, config('app.locales'))) ? $raw : config('app.locale');

		/*
		 * Set application local globally
		 */
		app()->setLocale($locale);

        /*
         * Set date'n time local globally
         */
        Carbon::setLocale($locale);

		return $next($request);
	}
}