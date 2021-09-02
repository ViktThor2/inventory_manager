<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Gate;
use DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Models\{Company, User, Role};

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $companies = Company::all();

        return view('crud.user')
            ->with('roles', $roles)
            ->with('companies', $companies);
    }

    public function getUser(Request $request)
    {
        $data = User::select(['id','name','email','role_id']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('Role', function ($users) {
                return $users->role->name ?? '';
            })
            ->addColumn('Companies', function ($users) {
                $ret = [];
                foreach ($users->companies as $company):
                    $ret[] .= $company->name ?? '';
                endforeach;
                return implode('; ', $ret);
            })
            ->addColumn('Actions', function($users) {
                return '<button type="button" class="btn btn-link btn-sm" id="getEditUserData" data-id="'.$users->id.'"><i class="fas fa-edit fa-lg"></i></button>
                    <button type="button" data-id="'.$users->id.'" data-toggle="modal" data-target="#DeleteUserModal" class="btn btn-link btn-sm" id="getDeleteId"><i style="color:red" class="fas fa-trash-alt fa-lg"></i></button>';
            })
            ->rawColumns(['Role', 'Companies', 'Actions'])
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user = New User();
        $user->setData($request->all());
        $user->save();
        $user->companies()->attach($request->companies);

        return response()->json(['success'=>'Felhasználó létrehozva']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = new User;
        $data = $user->findData($id);

        $optionsCompany = '';
        $companies = Company::all();

        foreach($companies as $company):
            $optionsCompany.='<option value="'.$company->id.'">'.$company->name.'</option>';
        endforeach;

        $optionRole = '';
        $roles = Role::all();

        foreach ($roles as $role):
            $optionRole.='<option value="'.$role->id.'">'.$role->name.'</option>';
        endforeach;

        $html = '<div class="form-group">
                    <label for="Name">Név :</label>
                    <input type="text" class="form-control" name="name" id="editName" value="'.$data->name.'">
                </div>
                <div class="form-group">
                    <label for="Email">Email cím:</label>
                    <input type="email" class="form-control" name="email" id="editEmail" value="'.$data->email.'">
                </div>
                <div class="form-group">
                    <label for="Password">Jelszó :</label>
                    <input type="password" class="form-control" name="password" id="editPassword" >
                </div>
                <div class="form-group">
                    <label for="Password_confirmation">Jelszó megerősítése :</label>
                    <input type="password" class="form-control" name="password_confirmation" id="editPassword_confirmation" >
                </div>
                <div class="form-group">
                    <select class="form-control select2" name="companies[]" id="editCompanies" multiple>
                        <option value=""  selected>Kérem válasszon céget</option>
                         '.$optionsCompany.'
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control select2" name="role_id" id="editRole_id" >
                    <option value=""  selected>Kérem válasszon szerepkört</option>
                        '.$optionRole.'
                    </select>
                </div>';

        return response()->json(['html'=>$html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->setData($request->all());
        $user->update();
        $user->companies()->sync($request->companies);

        return response()->json(['success'=>'Felhasználó frissítve']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = new User;
        $user->deleteData($id);

        return response()->json(['success'=>'Felhasználó törölve']);
    }
}
