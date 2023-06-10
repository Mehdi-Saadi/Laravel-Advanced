<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{

    use TwoFactorAuthnticate;

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                ]);
            }

            auth()->loginUsingId($user->id);


            return $this->loggendin($request, $user) ?: redirect('/');
        } catch (\Exception $e) {
            alert('', 'ورود با گوگل موفق نبود', 'error');
            return redirect('/login');
        }

    }
}
