<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Admin::with('roles')->get();
        return response()->view('cms.admin.index' ,  compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = City::all();
        return response()->view('cms.admin.create', ['cities' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'user_name' => 'required|string|min:3|max:40|alpha',
            'user_email' => 'required|email|unique:users,email',
            'city_id' => 'required|numeric|exists:cities,id',
            'active' => 'nullable|string|in:on',
            'user_password' => 'required|string'
        ]);

        $admin = new Admin();
        $admin->name = $request->input('user_name');
        $admin->city_id = $request->input('city_id');
        $admin->email = $request->input('user_email');
        $admin->password = Hash::make($request->input('user_password'));
        $admin->active = $request->has('active');
        $admin->gender = $request->gender;
        $isSaved = $admin->save();
        if($isSaved){
            session()->flash('message', 'Admin created successfully');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
        $data = City::Where('active', '=', true)->get();
        $roles = Role::Where('guard_name', '=', 'admin')->get();;
        $currentRole = $admin->roles[0];
        return response()->view('cms.admin.edit' ,compact('admin' ,'data','roles','currentRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
        $request->validate([
            'user_name' => 'required|string|min:3|max:40|alpha',
            'user_email' => 'required|email|unique:users,email',
            'city_id' => 'required|numeric|exists:cities,id',
            'role_id' => 'required|numeric|exists:roles,id',
            'active' => 'nullable|string|in:on',
        ]);

        $admin->name = $request->input('user_name');
        $admin->city_id = $request->input('city_id');
        $admin->email = $request->input('user_email');
        $admin->active = $request->has('active');
        $isSaved = $admin->save();
        if($isSaved){
            $admin->syncRoles(Role::findById($request->input('role_id'), 'admin'));
            session()->flash('message', 'Admin Edit successfully');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
        $isDeleted = $admin->delete();
        return redirect()->route('admins.index');
    }
}
