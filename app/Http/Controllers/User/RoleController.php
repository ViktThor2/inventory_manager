<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Gate;
use App\Http\Controllers\Controller;
use App\Models\{Role, Permission};

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('crud.role')->with('permissions', $permissions);
    }

    public function getRole(Request $request)
    {
        $roles = Role::all();

        return \DataTables::of($roles)
            ->addColumn('Permission', function ($roles) {
                $ret = [];
                foreach ($roles->permissions as $permission):
                    $ret[] .= $permission->name ?? '';
                endforeach;
                return implode(', ', $ret);
            })
            ->addColumn('Actions', function($roles) {
                return '<button type="button" class="btn btn-link btn-sm" id="getEditRoleData" data-id="'.$roles->id.'"><i class="fas fa-edit fa-lg"></i></button>
                    <button type="button" data-id="'.$roles->id.'" data-toggle="modal" data-target="#DeleteRoleModal" class="btn btn-link btn-sm" id="getDeleteId"><i style="color:red" class="fas fa-trash-alt fa-lg"></i></button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::find($request->role);
        $role->permissions()->attach($request->permissions);

        return response()->json(['success' => 'Jogosultság hozzá adva']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $optionsPermissions = '';
        $permissions = Permission::all();

        foreach($permissions as $permission):
            $optionsPermissions.='<option value="'.$permission->id.'">'.$permission->name.'</option>';
        endforeach;

        $html = '<div class="form-group">
                    <select class="form-control select2" name="companies[]" id="editCompanies" multiple>
                        <option value=""  selected>Kérem válasszon jogosultságokat</option>
                         '.$optionsPermissions.'
                    </select>
                </div>';

        return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->permissions()->attach($request->permissions);

        return response()->json(['success' => 'Szerep jogosultsága frissítve']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
