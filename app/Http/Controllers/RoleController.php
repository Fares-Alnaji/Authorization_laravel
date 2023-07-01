<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::withCount('permissions')->get();
        return response()->view('cms.roles.index' , compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return response()->view('cms.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(),[
            'guard' => 'required|string|in:admin,user',
            'name' => 'required|string'
        ]);

        if(! $validator->fails()){
            $role = new Role();
            $role->name = $request->input('name');
            $role->guard_name = $request->input('guard');
            $isSaved = $role->save();
            return response()->json([
                'message' => $isSaved ? 'Created successfully' : 'Create Failed!',
            ],
             $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    public function editRolePermissions(Request $request , Role $role)
    {
        $permissions = Permission::where('guard_name' , '=' , $role->guard_name)->get();
        $rolePermissions = $role->permissions;
        if(count($rolePermissions) > 0){
            foreach ($permissions as $permission){
                $permission->setAttribute('assigned', false);
                foreach($rolePermissions as $rolePermission){
                    if($permission->id == $rolePermission->id){
                        $permission->setAttribute('assigned', true);
                    }
                }
            }
        }
        return response()->view('cms.roles.role-permissions' , compact('role','permissions'));
    }

    public function updateRolePermissions(Request $request , Role $role)
    {
         //
         $Validator = Validator($request->all(),[
            'permission_id' => 'required|numeric|exists:permissions,id',
        ]);

        if(!$Validator->fails()){
            $permission = Permission::findById($request->input('permission_id'),'admin');
            $role->hasPermissionTo($permission)
            ? $role->revokePermissionTo($permission)
            :  $role->givePermissionTo($permission);

            return response()->json(['message' => 'Permission updated successfully'], Response::HTTP_OK);

        }else{
            return response()->json(['message' => $Validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
        return response()->view('cms.roles.edit' , compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        $validator = Validator($request->all(),[
            'guard' => 'required|string|in:admin,user',
            'name' => 'required|string'
        ]);

        if(! $validator->fails()){
            $role->name = $request->input('name');
            $role->guard_name = $request->input('guard');
            $isSaved = $role->save();
            return response()->json([
                'message' => $isSaved ? 'Updated successfully' : 'Updated Failed!',
            ],
             $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
        $deleted = $role->delete();
        return response()->json([
            'message' => $deleted ? 'Deleted successfully' : 'Deleted Failed!',
        ],
         $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
