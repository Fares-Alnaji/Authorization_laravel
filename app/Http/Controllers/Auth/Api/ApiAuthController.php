<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserForgetPasswordEmail;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator($request->all(), [
            'full_name' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);
        if (!$validator->fails()) {
            // dd($validator->fails());
            $user = new User();
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $isSaved = $user->save();
            return response()->json(
                ['status' => $isSaved, 'message' => $isSaved ? 'Registered Successfully' : 'Registration Failed'],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function personalLogin(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $user = User::where('email', '=', $request->input('email'))->first();
            if (Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken('User-Api');
                $user->setAttribute('token', $token->accessToken);
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Login in successfully',
                        'data' => $user
                    ],
                    Response::HTTP_OK
                );
            } else {
                return response()->json(
                    ['status' => false, 'message' => 'Wrong Password, try again!'],
                    Response::HTTP_BAD_REQUEST
                );
            };
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function passwordGrantLogin(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        if (!$validator->fails()) {
            try {
                $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', [
                    'grant_type' => 'password',
                    'client_id' => '6',
                    'client_secret' => 'rYXfsas5tRZ4St09GTDh2JBgkRuOUBowgqpzG8Oq',
                    'username' => $request->input('email'),
                    'password' => $request->input('password'),
                ]);
                $user = User::where('email', '=', $request->input('email'))->first();
                $jsonResponse = $response->json();
                $user->setAttribute('token', $jsonResponse['access_token']);
                return response()->json(
                    ['message' => 'Login successful' , 'object' => $user],
                    Response::HTTP_OK
                );
            } catch (\Throwable $th) {
                return response()->json(
                    ['status' => false , 'message' => $th->getMessage()],
                    Response::HTTP_BAD_REQUEST
                );
            }
        } else {
            return response()->json(
                ['status' => false, 'message' => 'Wrong Password, try again!'],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function logout(Request $request)
    {
        // return auth('user-api')->user()->token();
        $token = $request->user('user-api')->token();
        $revoked = $token->revoke();
        return response()->json(
            ['status' => $revoked, 'message' => $revoked ? 'Logged out Successfully' : 'Logout Failed!'],
            $revoked ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if (!$validator->fails()) {
            $code = random_int(1000, 9000);
            $user = User::where('email', '=', $request->input('email'))->first();
            $user->verification_code = Hash::make($code);
            $isSaved = $user->save();
            if ($isSaved) {
                Mail::to($user)->send(new UserForgetPasswordEmail($user, $code));
            }
            return response()->json(
                ['status' => $isSaved, 'message' => $isSaved ? 'Forgot code send Successfully' : 'Forgot code sending Failed!'],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'code' => 'required|numeric|digits:4',
            'new_password' => [
                'required', 'confirmed', 'string', Password::min(6)
                // ->letters()
                // ->symbols()
                // ->numbers()
                // ->mixedCase()
                // ->uncompromised()
            ]
        ]);
        if (!$validator->fails()) {
            $user = User::where('email', '=', $request->input('email'))->first();
            if (!is_null($user->verification_code)) {
                if (Hash::check($request->input('code'), $user->verification_code)) {
                    $user->password = Hash::make($request->input('new_password'));
                    $user->verification_code = null;
                    $isSaved = $user->save();
                    return response()->json(
                        ['status' => $isSaved, 'message' => $isSaved ? 'Password Change Successfully' : 'Password Change Failed!'],
                        $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
                    );
                } else {
                    return response()->json(
                        ['status' => false, 'message' => 'Verification code is not correct!'],
                        Response::HTTP_BAD_REQUEST
                    );
                }
            } else {
                return response()->json(
                    ['status' => false, 'message' => 'No password reset request exists, operation denied.'],
                    Response::HTTP_FORBIDDEN
                );
            }
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator($request->all(), [
            'current_password' => 'required|current_password:user-api',
            'new_password' => [
                'required', 'confirmed', 'string', Password::min(6)
                // ->letters()
                // ->symbols()
                // ->numbers()
                // ->mixedCase()
                // ->uncompromised()
            ]
        ]);
        if (!$validator->fails()) {
            $user = $request->user('user-api');
            $user->password = Hash::make($request->input('new_password'));
            $isSaved = $user->save();
            return response()->json(
                ['status' => $isSaved, 'message' => $isSaved ? 'Password Change Successfully' : 'Password Change Failed!'],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
