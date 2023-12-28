<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticatedSessionController extends AppBaseController
{
    public function auth(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->sendResponse(false, null, null, 'Invalid credentials');
            }
            /* $user = Auth::user();
            if ($user->email_verified_at === null) {
                return $this->sendResponse(null, null, 'Please verify your email address');
            } */
            $user = Auth::user();
            $user->update(['last_login' => Carbon::now()]);
            return response()->json(compact('token'));
        } catch (JWTException $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->sendResponse(false, null, null, 'Could not create token');
        }
    }

    public function logout()
    {
        // User Logout
        try {
            if (Auth::check()) {
                Auth::logout();
                return $this->sendResponse(true, null, 'User logged out successfully', null);
            }
            return $this->sendResponse(false, null, null, 'User not authenticated');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->sendResponse(false, null, null, 'It\'s a technical error! Please reach out to our customer service.');
        }
    }

    public function authMe()
    {
        try {
            $user = Auth::user();

            $Data = [
                'id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'join_date' => Carbon::parse($user->created_at)->format('Y-m-d'),
            ];

            return $this->sendResponse(true, $Data, 'Fetch data successfully!', null);
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->sendResponse(false, null, null, 'It\'s a technical error! Please reach out to our customer service.');
        }
    }
}
