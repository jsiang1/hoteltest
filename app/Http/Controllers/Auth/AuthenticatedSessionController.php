<?php
/**
 * @author Tan Xuan Ying
 */
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Http;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        // Attempt authentication using the main project's database
        if (Auth::attempt($credentials)) {
            // Authentication successful
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // If authentication using local database fails, try authentication via web service
        $response = Http::post('http://127.0.0.1:8081/api/authenticate', $credentials);

        // Check if the request to the web service was successful
        if ($response->successful()) {
            // Authentication successful
            $userData = $response->json();

            $user = User::firstOrCreate([
                'id'=> $userData['id'],
                'name' => $userData['name'],
                'gender'=> $userData['gender'],
                'phone'=> $userData['phone'],
                'email' => $userData['email'],
                'password' => bcrypt($credentials['password']),
            ],
            );

            // Log the user in using Laravel's authentication
            auth()->login($user);

            // Regenerate the session
            $request->session()->regenerate();

            // Redirect the user to the intended page
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // If authentication using both methods fails, redirect back to the login page with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
