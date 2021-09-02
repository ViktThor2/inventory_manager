<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Partner;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crud.partner');
    }

    public function getPartner(Request $request)
    {
        $partners = Partner::all();
        return \DataTables::of($partners)
            ->addColumn('Actions', function($partners) {
                return '<button type="button" class="btn btn-link btn-sm" id="getEditPartnerData" data-id="'.$partners->id.'"><i class="fas fa-edit fa-lg"></i></button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partner = Partner::find($id);

        $html = '<div class="form-group">
                    <label for="Name">Név :</label>
                    <input type="text" class="form-control" name="contactName" id="editContactName" value="'.$partner->contactName.'">
                </div>
                <div class="form-group">
                    <label for="Name">Telefonszám :</label>
                    <input type="tel" class="form-control" name="contactPhone" id="editContactPhone" value="'.$partner->contactPhone.'">
                </div>';

        return response()->json(['html'=>$html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $partner = Partner::find($id);
        $partner->contactName = $request->contactName;
        $partner->contactPhone = $request->contactPhone;
        $partner->update();

        return response()->json(['success' => 'Partner frissítve']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partner = Partner::find($id);
        $partner->destroy();

        return response()->json(['succes' => 'Partner törölve']);
    }
}
