<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Notifications\ActiveCode as ActiveCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TwoFactorAuthController extends Controller
{
    public function manageTowFactor()
    {
        return view('profile.two-factor-auth');
    }

    public function postManageTowFactor(Request $request)
    {
        $data = $this->validateRequestData($request);

        if ($this->isRequestTypeSms($data['type'])) {
            if ($request->user()->phone_number !== $data['phone']) {
                return $this->createCodeAndSendSms($request, $data['phone']);
            } else {
                $request->user()->update([
                    'two_factor_type' => 'sms',
                ]);
            }
        }

        if ($this->isRequestTypeOff($data['type'])) {
            $request->user()->update([
                'two_factor_type' => 'off',
            ]);
        }

        return back();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validateRequestData(Request $request): array
    {
        $data = $request->validate([
            'type' => 'required|in:sms,off',
            'phone' => [
                'required_unless:type,off',
                Rule::unique('users', 'phone_number')->ignore($request->user()->id, 'id'),
            ],
        ]);
        return $data;
    }

    /**
     * @param $type
     * @return bool
     */
    public function isRequestTypeSms($type): bool
    {
        return $type === 'sms';
    }

    /**
     * @param Request $request
     * @param $phone
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createCodeAndSendSms(Request $request, $phone): \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\Foundation\Application
    {
        $request->session()->flash('phone', $phone);

        // create a new code
        $code = ActiveCode::generateCode($request->user());

        // send sms
        $request->user()->notify(new ActiveCodeNotification($code, $phone));

        return redirect(route('profile.2fa.phone'));
    }

    /**
     * @param $type
     * @return bool
     */
    public function isRequestTypeOff($type): bool
    {
        return $type === 'off';
    }
}
