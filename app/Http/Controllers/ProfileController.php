<?php

namespace App\Http\Controllers;

use App\Models\ActiveCode;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        return view('profile.index');
    }

    public function manageTowFactor()
    {
        return view('profile.two-factor-auth');
    }

    public function postManageTowFactor(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:sms,off',
            'phone' => 'required_unless:type,off',
        ]);

        if ($data['type'] === 'sms') {
            if ($request->user()->phone_number !== $data['phone']) {
                // create a new code and send to user
                $code = ActiveCode::generateCode();

                return $code;

                return redirect(route('profile.2fa.phone'));
            } else {
                $request->user()->update([
                    'two_factor_type' => 'sms',
                ]);
            }
        }

        if ($data['type'] === 'off') {
            $request->user()->update([
                'two_factor_type' => 'off',
            ]);
        }

        return back();
    }

    public function getPhoneVerify()
    {
        return view('profile.phone-verify');
    }

    public function postPhoneVerify(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        return $request->token;
    }
}
