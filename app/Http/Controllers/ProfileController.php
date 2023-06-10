<?php

namespace App\Http\Controllers;

use App\Models\ActiveCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'phone' => [
                'required_unless:type,off',
                Rule::unique('users', 'phone_number')->ignore($request->user()->id, 'id'),
            ],
        ]);

        if ($data['type'] === 'sms') {
            if ($request->user()->phone_number !== $data['phone']) {
                // create a new code
                $code = ActiveCode::generateCode($request->user());
                $request->session()->flash('phone', $data['phone']);
                // TODO send sms

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
