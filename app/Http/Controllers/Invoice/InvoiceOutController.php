<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Nav\{
    NavInvoiceOut, NavInvoiceOutItem
};

class InvoiceOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoice.out.crud');
    }

    public function getInvoiceOut(Request $request)
    {
        $invoices = NavInvoiceOut::select([
            'id', 'customerName', 'invoiceNumber', 'invoiceIssueDate', 'supplierName',
            'paymentMethod', 'paymentDate', 'invoiceNetAmount', 'invoiceVatAmount', 'currency'
        ]);

        return \DataTables::of($invoices)
            ->addColumn('brutto', function($invoices) {
                $brutto = $invoices->invoiceNetAmount + $invoices->invoiceVatAmount;
                return $brutto;
            })
            ->addColumn('Actions', function($invoices) {
                return '<a href="'.route('invoiceout.show', $invoices->id).'" class="btn btn-link btn-sm"><i class="fas fa-edit fa-lg"></i></button>';
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NavInvoiceOut  $navInvoiceOut
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = NavInvoiceOut::find($id);

        $invoice->allQty = 0;
        foreach ($invoice->nav_invoice_out_items as $item):
            $invoice->allQty += $item->quantity;
        endforeach;

        return view('invoice.out.item')
            ->with('invoice', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NavInvoiceOut  $navInvoiceOut
     * @return \Illuminate\Http\Response
     */
    public function edit(NavInvoiceOut $navInvoiceOut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NavInvoiceOut  $navInvoiceOut
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NavInvoiceOut $navInvoiceOut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NavInvoiceOut  $navInvoiceOut
     * @return \Illuminate\Http\Response
     */
    public function destroy(NavInvoiceOut $navInvoiceOut)
    {
        //
    }
}
