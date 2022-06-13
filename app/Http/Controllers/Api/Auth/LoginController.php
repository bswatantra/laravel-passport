<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HasEmailOrMobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use HasEmailOrMobile;

    public function __invoke()
    {
        $validated = $this->validateAttributes();
        $checkEmailOrMobile = $this->checkEmailOrMobile($validated);

        if ($checkEmailOrMobile == 'email')
            return 'email';
        return 'mobile';
//        return $this->generateOTP($validated);
    }

    private function validateAttributes(): \Illuminate\Http\JsonResponse|array
    {
        if (is_numeric(\request('username'))) {
            $validator = Validator::make(\request()->all(), array(
                'username' => 'required|numeric|digits:10'
            ));
        } else {
            $validator = Validator::make(\request()->all(), array(
                'username' => 'required|email'
            ));
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validation errors',
                'data' => $validator->errors()
            ], 422);
        }

        return $validator->validated();
    }


    private function generateOTP($attributes)
    {

    }
}
