<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use Illuminate\Http\Request;

class TokenAuthController extends Controller
{
    public function getPhoneVerify(Request $request)
    {
        if (!$request->session()->has('phone')) {
            return redirect(route('profile.2fa.manage'));
        }

        $request->session()->reflash();

        return view('profile.phone-verify');
    }

    public function postPhoneVerify(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        if (!$request->session()->has('phone')) {
            return redirect(route('profile.2fa.manage'));
        }

        $status = ActiveCode::verifyCode($request->token, $request->user());

        if ($status) {
            $request->user()->activeCode()->delete();
            $request->user()->update([
                'phone_number' => $request->session()->get('phone'),
                'two_factor_type' => 'sms'
            ]);

            alert('', 'شماره تلفن و احرازهویت دو مرحله ای شما تایید شد', 'success');
        } else {
            alert('', 'شماره تلفن و احرازهویت دو مرحله ای شما تایید نشد', 'error');
        }

        return redirect(route('profile.2fa.manage'));
    }
}
