<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HasEmailOrMobile;
use App\Traits\Responsible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use HasEmailOrMobile, Responsible;

    public function __invoke()
    {
        $validator = $this->validateAttributes();
        if ($validator->fails()) {
            return $this->response('error', 'validation errors', $validator->errors(), 422);
        }
        $validated = $validator->validated();

        if ($this->checkEmailOrMobile($validated) == 'email')
            return 'email';
        return 'mobile';
//        return $this->generateOTP($validated);
    }

    private function validateAttributes(): \Illuminate\Contracts\Validation\Validator
    {
        if (is_numeric(request('username'))) {
            $validator = Validator::make(request()->all(), array(
                'username' => 'required|numeric|digits:10'
            ));
        } else {
            $validator = Validator::make(request()->all(), array(
                'username' => 'required|email'
            ));
        }
        return $validator;
    }


    private function generateOTP($attributes)
    {
        $otp = rand(100000, 999999);

        //save otp to database with user id

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your mobile',
            'data' => $otp
        ], 200);
    }
}
