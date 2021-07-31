<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Utilities\ProxyRequest;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    protected $proxy;

    public function __construct(ProxyRequest $proxy)
    {
        $this->proxy = $proxy;
    }

    public function login(LoginRequest $request)
    {
       $user = User::where('email', $request->email)->first();
        abort_unless($user, 422, 'This combination does not exists.');
        abort_unless(
            \Hash::check(request('password'), $user->password),
            422,
            'This combination does not exists.'
        );
        $resp = $this->proxy->grantPasswordToken(request('email'), request('password'));

        return response([
            'token' => $resp->access_token,
            'llv' => $resp->refresh_token,
            'expiresIn' => $resp->expires_in,
            'message' => 'You have been logged In',
            'user' => $user
        ], 200);
    }
    public function refreshToken(Request $request)
    {

        $resp = $this->proxy->refreshAccessToken($request);

        return response([
            'token' => $resp->access_token,
            'expiresIn' => $resp->expires_in,
            'llv' => $resp->refresh_token,
            'message' => 'Token has been refreshed.',
        ], 200);
    }

    public function logout()
    {
        $token = request()->user()->token();
        $token->delete();
        // remove the httponly cookie
        cookie()->queue(cookie()->forget('refresh_token'));

        return response([
            'message' => 'You have been successfully logged out',
        ], 200);
    }

}
