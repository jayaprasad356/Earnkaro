<?php

namespace App\Http\Controllers\Auth;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginDetail;
use App\Models\Utility;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use WhichBrowser\Parser;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function __construct()
    {
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        }
    }

    /*protected function authenticated(Request $request, $admin)
    {
        if($admin->delete_status == 1)
        {
            auth()->logout();
        }

        return redirect('/check');
    }*/

    public function store(LoginRequest $request)
    {
        $settings = Utility::settings();
        if (isset($settings['recaptcha_module']) && $settings['recaptcha_module'] == 'yes') {
            $validation['g-recaptcha-response'] = 'required';
        } else {
            $validation = [];
        }
        $this->validate($request, $validation);
    
        $request->authenticate(); // Authenticate the user
    
        $request->session()->regenerate(); // Regenerate session to prevent session fixation attacks
    
        $admins = Auth::guard('web')->user(); // Get authenticated user (admin)
    
      
    
        $login_detail = new LoginDetail(); // Create a new login detail
    }
    

    public function showLoginForm($lang = '')
    {
        if ($lang == '') {
            $lang = \App\Models\Utility::getValByName('default_language');
        }
        \App::setLocale($lang);

        return view('auth.login', compact('lang'));
    }

    public function showLinkRequestForm($lang = '')
    {
        if ($lang == '') {
            $lang = \App\Models\Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.forgot-password', compact('lang'));
    }
    public function storeLinkRequestForm(Request $request)
    {
        $settings = Utility::settings();
        if (isset($settings['recaptcha_module']) && $settings['recaptcha_module'] == 'yes') {
            $validation['g-recaptcha-response'] = 'required';
        } else {
            $validation = [];
        }
        $this->validate($request, $validation);

        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this admin. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the admin. Finally, we'll send out a proper response.
        try {

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status == Password::RESET_LINK_SENT
                ? back()->with('status', __($status))
                : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {

            return redirect()->back()->withErrors('E-Mail has been not sent due to SMTP configuration');
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

        return redirect('/login');
    }
}
