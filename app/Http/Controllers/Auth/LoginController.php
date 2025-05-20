<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $user = User::where('email', $request->email)->first();


        if ($user && is_null($user->password)) {
            return back()->withErrors(['error' => 'This account is linked to a social media login. Please log in using Google or GitHub.']);
        }


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $role_id = $user->role_id;


            if ($role_id == 1) {
                return redirect()->route('indexUser');
            } elseif ($role_id == 2) {
                return redirect()->route('deliveries.pending');
            } elseif ($role_id == 3) {
                return redirect()->route('indexAdmin');
            } else {
                Auth::logout();
                return back()->withErrors(['error' => 'Invalid credentials or role']);
            }
        }


        return back()->withErrors(['error' => 'Invalid credentials']);
    }
}

