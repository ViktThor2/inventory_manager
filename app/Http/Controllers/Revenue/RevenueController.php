<?php

namespace App\Http\Controllers\Revenue;

use App\Models\{Revenue, RevenueItem};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RevenueController extends Controller
{
    public function index()
    {
/*
        $revenues = Revenue::NewRevenue()->paginate(20);
        foreach ($revenues as $revenue):
            $invoice = $revenue->nav_invoice_in()->first();
            $invoices[] = $invoice->setRevenueIndex($revenue);
        endforeach;

        $revenue = Revenue::find(433);
        dd($revenue->revenue_items);
*/
        return view('revenue.index');
    }

    public function getRevenue(Request $request)
    {
        $revenues = Revenue::NewRevenue()->paginate(200);
        foreach ($revenues as $revenue):
            $invoice = $revenue->nav_invoice_in()->first();
            $invoices[] = $invoice->setRevenueIndex($revenue);
        endforeach;

        return \DataTables::of($invoices)
            ->addIndexColumn()
            ->addColumn('Actions', function ($invoices) {
                return '<a href="' . route('revenue.show', $invoices->id) .
                    '" class="btn btn-link btn-sm border"><i class="far fa-plus-square"></i></button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    public function all(Request $request)
    {
        if ($request->ajax()) {
            $revenues = Revenue::all();
            foreach ($revenues as $revenue):
                $invoice = $revenue->nav_invoice_in()->first();
                $invoices[] = $invoice->setRevenueIndex($revenue);
            endforeach;

            return \DataTables::of($invoices)
                ->addIndexColumn()
                ->addColumn('Actions', function ($invoices) {
                    return '<a href="' . route('revenue.show', $invoices->id) .
                        '" class="btn btn-link btn-sm border"><i class="far fa-plus-square"></i></button>';
                })
                ->rawColumns(['Actions'])
                ->make(true);
        }

        return view('revenue.all');

    }

    public function show($id)
    {
        $revenues = Revenue::NewRevenue()->get();
        foreach ($revenues as $revenue){
            if($revenue->nav_invoice_in->company->id == 1){
                dd($revenue->nav_invoice_in->company->name);
            }
        }


        $revenue = Revenue::find($id);
        $revenue->setShow();

        return view('revenue.show')
            ->with('revenue', $revenue);
    }

    public function inStock($id, Request $request)
    {
        foreach ($request->data as $item):
            $revenueItem = RevenueItem::find($item);
            $revenueItem->status_id = 10;
            $revenueItem->update();
        endforeach;

        $revenue = Revenue::find($id);
        $revenue->setStatus();

        return response()->json(['success'=>'Termék(ek) bevételezve']);
    }

}
