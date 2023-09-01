<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::withCount('permissions')->get();
        return response()->view('cms.user.index' , compact('users'));
    }

    public function editPermissions(Request $request , User $user)
    {
        $permissions = Permission::where('guard_name', '=' , 'user')
        ->orWhere('guard_name', '=' , 'user-api')->get();
        $userPermissions = $user->permissions;
        foreach ($permissions as $permission){
            $permission->setAttribute('assigned', false);
            foreach($userPermissions as $userPermission){
                if($permission->id == $userPermission->id){
                    $permission->setAttribute('assigned', true);
                }
            }

    }
        return response()->view('cms.user.user-permissions' , compact('user', 'permissions'));
    }

    public function updatePermissions(Request $request , User $user)
    {
        $Validator = Validator($request->all(),[
            'permission_id' => 'required|numeric|exists:permissions,id',
        ]);

        if(!$Validator->fails()){
            // $permission = Permission::findById($request->input('permission_id'),'user');
            $permission = Permission::findOrFail($request->input('permission_id'));
            $user->hasPermissionTo($permission)
            ? $user->revokePermissionTo($permission)
            :  $user->givePermissionTo($permission);

            return response()->json(['message' => 'Permission updated successfully'], Response::HTTP_OK);

        }else{
            return response()->json(['message' => $Validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return response()->view('cms.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(),[
            'full_name' => 'required|string|max:30',
            'email' => 'required|email',
            'user_password' => 'required|string',
        ]);

        if(! $validator->fails()){
            $user = new User();
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('user_password'));
            $isSaved = $user->save();
            if($isSaved){
                session()->flash('message', 'User created successfully');
                return redirect()->back();
            }
        }else{
            return response()->json(['message' => $validator->getMessageBag()->first()] , Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        return response()->view('cms.user.edit' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $validator = Validator($request->all(),[
            'full_name' => 'required|string|max:30',
            'email' => 'required|email',
        ]);

        if(! $validator->fails()){
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $isSaved = $user->save();
            if($isSaved){
                session()->flash('message', 'User created successfully');
                return redirect()->back();
            }
        }else{
            return response()->json(['message' => $validator->getMessageBag()->first()] , Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        //
        $isDeleted = $user->delete();
        return redirect()->route('users.index');
    }
}
