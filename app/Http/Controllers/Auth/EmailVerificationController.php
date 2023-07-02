<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailVerificationController extends Controller
{
    //
    public function notice(Request $request)
    {
        return response()->view('cms.auth.email-verify-notice');
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(
            ['message' => 'Verification sent successfully!'],
            Response::HTTP_OK
        );
    }

    public function verify(EmailVerificationRequest $emailVerificationRequest)
    {
        if($emailVerificationRequest->authorize()){
            $emailVerificationRequest->fulfill();
            return redirect()->route('cms.dashboard');
        }else{
            return response()->json(
                ['message' => 'Email Verification is not authorize!'],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
