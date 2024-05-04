<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success([
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        Permission::create($request->all());
        return $this->success([
            'message' => 'Permission created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return $this->success([
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        $permission->update($request->all());
        return $this->success([
            'message' => 'Permission updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        Permission::where('id', $permission->id)->delete();

        return $this->success([
            'message' => 'Permission deleted successfully'
        ]);
    }
}
