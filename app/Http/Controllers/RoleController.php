<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success([
            'roles' => Role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
        ]);

        Role::create($request->all());
        return $this->success([
            'message' => 'Role created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return $this->success([
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
        ]);

        $role->update($request->all());
        return $this->success([
            'message' => 'Role updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Role::where('id', $role->id)->delete();

        return $this->success([
            'message' => 'Role deleted successfully'
        ]);
    }
}
