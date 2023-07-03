<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class ForgetPasswordController extends Controller
{
    //
    public function showPasswordReset(Request $request)
    {
        return response()->view('cms.auth.forgot-password');
    }

    public function sendRestEmail(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email',
        ]);

        if (!$validator->fails()) {
            $status = Password::sendResetLink($request->only('email'));
            return $status === Password::RESET_LINK_SENT
                ? response()->json(['message' => __($status)], Response::HTTP_OK)
                : response()->json(['message' => __($status)], Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function resetPassword(Request $request, $token)
    {
        return response()->view(
            'cms.auth.recover-password',
            ['token' => $token, 'email' => $request->input('email')]
        );
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        if (!$validator->fails()) {
           $status = Password::reset($request->all(), function ($user ,$password){
            $user->password = Hash::make($password);
            $user->save();
            // $user->forceFill([
            //     'password' =>  Hash::make($password)
            // ]);
            event(new PasswordReset($user));
           });

           return $status === Password::PASSWORD_RESET
           ? response()->json(['message' => __($status)], Response::HTTP_OK)
           : response()->json(['message' => __($status)], Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
