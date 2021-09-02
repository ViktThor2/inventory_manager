<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Company;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crud.company');
    }

    public function getCompany(Request $request, Company $company)
    {
        $data = $company->getData();
        return \DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<button type="button" class="btn btn-link btn-sm" id="getEditCompanyData" data-id="'.$data->id.'"><i class="fas fa-edit fa-lg"></i></button>
                    <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteCompanyModal" class="btn btn-link btn-sm" id="getDeleteId"><i style="color:red" class="fas fa-trash-alt fa-lg"></i></button>';
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
    public function store(Request $request, Company $company)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'vat' => 'required',
            'postcode' => 'required',
            'city' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'nav_technical_username' => 'required',
            'nav_technical_password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $company->storeData($request->all());

        return response()->json(['success'=>'Cég létrehozva']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $html = '<div class="form-group">
                    <label for="Name">Név :</label>
                    <input type="text" class="form-control" name="name" id="editName" value="'.$company->name.'">
                </div>
                <div class="form-group">
                    <label for="Vat">Adószám:</label>
                    <input type="text" class="form-control" name="vat" id="editVat" value="'.$company->vat.'">
                </div>
                <div class="form-group">
                    <label for="Postcode">Irányítószám :</label>
                    <input type="text" class="form-control" name="postcode" id="editPostocde" value="'.$company->postcode.'">
                </div>
                <div class="form-group">
                    <label for="City">Város :</label>
                    <input type="text" class="form-control" name="city" id="editCity" value="'.$company->city.'">
                </div>
                <div class="form-group">
                    <label for="Address">Cím :</label>
                    <input type="text" class="form-control" name="address" id="editAddress" value="'.$company->address.'">
                </div>
                <div class="form-group">
                    <label for="Contact">Kapcsolattartó :</label>
                    <input type="text" class="form-control" name="contact" id="editContact" value="'.$company->contact.'">
                </div>
                <div class="form-group">
                    <label for="Nav_technical_username">Nav technikai felhasználónév:</label>
                    <input type="text" class="form-control" name="nav_technical_username" id="editNav_technical_username" value="'.$company->nav_technical_username.'">
                </div>
                <div class="form-group">
                    <label for="Nav_technical_password">Nav technikai jelszó:</label>
                    <input type="text" class="form-control" name="nav_technical_password" id="editNav_technical_password" value="'.$company->nav_technical_password.'">
                </div>
                <div class="form-group">
                    <label for="Nav_technical_signkey">Nav technikai aláírás:</label>
                    <input type="text" class="form-control" name="nav_technical_signkey" id="editNav_technical_signkey" value="'.$company->nav_technical_signkey.'">
                </div>
                <div class="form-group">
                    <label for="Nav_technical_exchangekey">Nav technikai aláírás:</label>
                    <input type="text" class="form-control" name="nav_technical_exchangekey" id="editNav_technical_exchangekey" value="'.$company->nav_technical_exchangekey.'">
                </div>';

        return response()->json(['html'=>$html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $company->update($request->all());

        return response()->json(['success'=>'Felhasználó frissítve']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = new Company();
        $company->deleteData($id);

        return response()->json(['success' => 'Cég törölve']);
    }
}
