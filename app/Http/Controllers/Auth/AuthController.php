<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    public function showLogin(Request $request)
    {
        $request->merge(['guard' => $request->guard]);

        $validator = Validator($request->all(),[
            'guard' => 'required|string|in:admin',
        ]);
        session()->put('guard', $request->input('guard'));
        if(! $validator->fails()){
            return response()->view('cms.auth.login');
        }else if($request->input('guard') == 'user'){
            return response()->view('cms.auth.login-user');
        } else {
            abort(404);
        }

    }

    public function login(Request $request)
    {
        $guard = session('guard');
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:'.$guard.'s'.',email',
            'password' => 'required|string',
            'remember' => 'required|boolean'
        ]);

        $guard = session('guard');
        if(!$validator->fails()){
            if(Auth::guard($guard)->attempt($request->only(['email' , 'password']), $request->input('remember')))
            {
                return response()->json(['message' => 'Logged in successfully'], Response::HTTP_OK);
            }else {
                return response()->json(['message' => 'Check email or password, try again'], Response::HTTP_BAD_REQUEST);
            }
        }else{
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function logout(Request $request)
    {
        $guard = session('guard');
        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        return redirect()->guest(route('auth.login' , $guard));
    }

    public function editPassword(){
        return response()->view('cms.auth.edit-password');
    }

    public function updatePassword(Request $request){
        $guard = session('guard');
        $validator = Validator($request->all(),[
            'current_password' => 'required|string|current_password:'. $guard,
            'new_password' => 'required|string|confirmed'
        ]);

        if(! $validator->fails()){
            $user =$request->user();
            $user->password = Hash::make($request->input('new_password'));
            $isSaved = $user->save();
            return response()->json(['message' => $isSaved ? 'Password changed successfully' : 'Failed to change password!'], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }
}
