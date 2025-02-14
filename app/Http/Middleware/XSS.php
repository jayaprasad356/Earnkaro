<?php

namespace App\Http\Middleware;

use App\Models\LandingPageSection;
use App\Models\Utility;
use App\Models\GenerateOfferLetter;
use Illuminate\Support\Facades\Config;
use Closure;
use Illuminate\Support\Facades\Schema;

class XSS
{
    use \RachidLaasri\LaravelInstaller\Helpers\MigrationsHelper;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::check()) {

            $settings = Utility::settings();
            if (!empty($settings['timezone'])) {
                Config::set('app.timezone', $settings['timezone']);
                date_default_timezone_set(Config::get('app.timezone', 'UTC'));
            }

        

          
        }

        return $next($request);
    }
}
