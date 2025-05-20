<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    
    public function handleGoogleCallback()
    {
        try {
            
            $googleUser = Socialite::driver('google')->user();
    
            
            $user = User::where('email', $googleUser->getEmail())->first();
    
            if (!$user) {
                
                $user = User::create([
                    'userName' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => null,  
                    'role_id' => Role::where('roleName', 'user')->first()->id,
                ]);
            }
    
           
            Auth::login($user);
    
            
            return redirect()->route('indexUser');
        } catch (\Exception $e) {
            \Log::error('GitHub login failed: ' . $e->getMessage());
            return redirect('auth/login')->with('error', 'Failed to login with GitHub.');
        }
        
    }
}
