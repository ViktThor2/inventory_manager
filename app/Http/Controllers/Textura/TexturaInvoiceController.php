<?php

namespace App\Http\Controllers\Textura;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Textura\{
    RevenueTextura
};

class TexturaInvoiceController extends Controller
{
    public function index()
    {
        return view('invoice.textura.in');
    }

    public function getTextura(Request $request)
    {
        $data = RevenueTextura::all();

        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('Action', function ($data) {
                return '<a href="'.route('textura.show', $data->id).'" class="btn btn-link btn-sm"><i class="fas fa-edit fa-lg"></i></button>';
                // return '<button type="button" class="btn btn-link btn-sm" id="getShowInvoiceData" data-id="' . $data->id . '"><i class="fas fa-edit fa-lg"></i></button>';
            })
            ->rawColumns(['Action'])
            ->make(true);
    }

    public function show($id)
    {
        $texturaInvoice = RevenueTextura::find($id);

        $texturaInvoice->quantity = 0;
        foreach ($texturaInvoice->revenue_textura_items as $item):
            $texturaInvoice->quantity += $item->quantity;
        endforeach;

        return view('invoice.textura.inItem')
            ->with('texturaInvoice', $texturaInvoice);
    }


}
