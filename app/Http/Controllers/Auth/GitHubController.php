<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class GitHubController extends Controller
{
    
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

   
    public function handleGitHubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            
            $user = User::where('email', $githubUser->getEmail())->first();

            if (!$user) {
                
                $user = User::create([
                    'userName' => $githubUser->getName(),
                    'email' => $githubUser->getEmail(),
                    'password' => null, 
                    'role_id' => Role::where('roleName', 'user')->first()->id,
                ]);
            }

            
            Auth::login($user);

           
            return redirect()->route('indexUser');
        } catch (\Exception $e) {
            return redirect('auth/login')->with('error', 'Failed to login with GitHub.');
        }
    }
}
