<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Gate;
use App\Http\Controllers\Controller;
use App\Models\{Permission, Role};

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crud.permission');
    }

    public function getPermission(Request $request)
    {
        $permissions = Permission::all();
        return \DataTables::of($permissions)
            ->addColumn('Actions', function($permissions) {
                return '<button type="button" class="btn btn-link btn-sm" id="getEditPermissionData" data-id="'.$permissions->id.'"><i class="fas fa-edit fa-lg"></i></button>
                    <button type="button" data-id="'.$permissions->id.'" data-toggle="modal" data-target="#DeletePermissionModal" class="btn btn-link btn-sm" id="getDeleteId"><i style="color:red" class="fas fa-trash-alt fa-lg"></i></button>';
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
        $permission = New Permission();
        $permission->name = $request->name;
        $permission->save();

        return response()->json(['success' => 'Jogosultság létrehozva']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);

        $html = '<div class="form-group">
                    <label for="Name">Név :</label>
                    <input type="text" class="form-control" name="name" id="editName" value="'.$permission->name.'">
                </div>';

        return response()->json(['html'=>$html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->update();

        return response()->json(['success' => 'Jogosultság frissítve']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->destroy();

        return response()->json(['succes' => 'Jogosultság törölve']);
    }
}
