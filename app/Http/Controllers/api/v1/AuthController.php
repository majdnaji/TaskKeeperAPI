<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\AuthRequests\AuthLoginRequest;
use App\Http\Requests\AuthRequests\AuthRegisterRequest;
use App\Http\Requests\AuthRequests\ChangePasswordRequest;
use App\Http\Requests\AuthRequests\CheckEmailVerificationRequest;
use App\Http\Requests\AuthRequests\CheckPasswordResetRequest;
use App\Http\Requests\AuthRequests\RequestResetPasswordRequest;
use App\Http\Requests\AuthRequests\ResetPasswordRequest;
use App\Http\Requests\AuthRequests\VerifyEmailRequest;
use App\Services\User\IUserService;
use Illuminate\Http\Request;

class AuthController extends ApiController
{




    public function login(AuthLoginRequest $request)
    {

        $token = auth()->attempt([
            'email' => $request['email'],
            'password' => $request['password'],
        ]);


        if (! $token) {
            return $this->apiResponse(null, self::STATUS_NOT_FOUND, __('site.credentials_not_match_records'));
        }


        return $this->apiResponse([
            'user' => auth()->user(),
            'token' => $token,
        ],
        self::STATUS_OK, __('site.successfully_logged_in'));
    }

    public function logout()
    {
        auth()->logout();

        return $this->apiResponse(null, self::STATUS_OK, __('site.logout_success'));
    }





    public function changePassword(ChangePasswordRequest $request)
    {
        $result = $this->user_service->changePassword($request->validated());
        if ($result) {
            return $this->apiResponse(true, self::STATUS_OK, __('site.password_changed_successfully'));
        }

        return $this->apiResponse(false, self::STATUS_OK, __('site.failed'));
    }






}
