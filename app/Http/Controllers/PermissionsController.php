<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permissions;

use App\Models\RolePermissions;
class PermissionsController extends Controller
{
    
public function getPermissions(){
    $permissions = Permissions::all();
    return response()->json(['permissions' => $permissions]);
}

public function getUserPermissions(Request $request){
    $roleId = $request->query('role');

    if (!$roleId) {
        return response()->json(['error' => 'Role ID required'], 400);
    }

    // Fetch permissions for the role
    $permissions = Roles::where('roleId', $roleId)
        ->with('permissions') // Assuming you've defined this relationship
        ->first()
        ->permissions
        ->pluck('permissionSlug'); // Get only permission slugs

    return response()->json(['permissions' => $permissions]);
}


public function createPermission(Request $request){
    $data = $request->all();
    Permissions::create($data);
    return response()->json(['message' => 'Permission created successfully']);
}

public function assignRoleToPermissions(Request $request){
    $data = $request->all();
    $role = Roles::find($data['roleId']);
   if (!$role) {
        return response()->json(['error' => 'Role not found'], 404);
    }
    else{
       RolePermissions::create($data);   
    }
    return response()->json(['message' => 'Permissions assigned to role successfully']);
}

}