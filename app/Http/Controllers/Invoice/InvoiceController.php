<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Nav\{
    NavInvoiceIn, NavInvoiceInItem
};

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoice.in.crud');
    }

    public function getInvoice(Request $request)
    {
        $invoices = NavInvoiceIn::select([
            'id', 'customerName', 'invoiceNumber', 'invoiceIssueDate', 'supplierName',
            'paymentMethod', 'paymentDate', 'invoiceNetAmount', 'invoiceVatAmount', 'currency'
        ]);

        return \DataTables::of($invoices)
            ->addColumn('brutto', function($invoices) {
                 $brutto = $invoices->invoiceNetAmount + $invoices->invoiceVatAmount;
                 return $brutto;
            })
            ->addColumn('Actions', function ($invoices) {
                return '<a href="'.route('invoice.show', $invoices->id).'" class="btn btn-link btn-sm"><i class="fas fa-edit fa-lg"></i></a>';
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
     * @param  \App\Models\NavInvoiceIn  $navInvoiceIn
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = NavInvoiceIn::find($id);

        $invoice->allQty = 0;
        foreach ($invoice->nav_invoice_in_items as $item):
            $invoice->allQty += $item->quantity;
        endforeach;

        return view('invoice.in.item')
            ->with('invoice', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NavInvoiceIn  $navInvoiceIn
     * @return \Illuminate\Http\Response
     */
    public function edit(NavInvoiceIn $navInvoiceIn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NavInvoiceIn  $navInvoiceIn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NavInvoiceIn $navInvoiceIn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NavInvoiceIn  $navInvoiceIn
     * @return \Illuminate\Http\Response
     */
    public function destroy(NavInvoiceIn $navInvoiceIn)
    {
        //
    }
}
