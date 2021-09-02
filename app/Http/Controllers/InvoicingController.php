<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Partner;
use App\Models\Statuses;
use Illuminate\Http\Request;
use App\Models\Revenue;
use App\Models\Nav\NavInvoiceIn;

class InvoicingController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::all();
        $statuses = Statuses::all();
        $partners = Partner::all();
        $invoices = [];

        if ($request->isMethod('post')){
            $search = $request->all();
        } elseif (session('search')) {
            $search = session()->get('search');
        } else {
            $search['payment'] = null;
            $search['PriceMin'] = null;
            $search['PriceMax'] = null;
            $search['company'] = null;
            $search['partner'] = null;
            $search['status'] = null;
            $search['invoiceNumber'] = null;
            $search['fromDate'] = date('Y-m-d', strtotime('-30 day'));
            $search['toDate'] = date("Y-m-d");
        }

        if(isset($search)):
            $invoices = NavInvoiceIn::SearchInvocing($search)->get();
            foreach ($invoices as $key => $invoice):
                $invoice->setInvocingIndex();
                if (isset($request->status)):
                    if ($invoice->searchStatus($request->status) != true):
                        unset($invoices[$key]);
                    endif;
                endif;
            endforeach;
            session()->put('search', $search);
        endif;

        return view('invoicing.index')
            ->with('companies', $companies)
            ->with('statuses', $statuses)
            ->with('partners', $partners)
            ->with('invoices', $invoices)
            ->with('search', $search);
    }

    public function show($id)
    {
        $invoice = NavInvoiceIn::find($id);
        $invoice->setQty();

        $statuses = Statuses::all();

        return view('invoicing.show')
            ->with('invoice', $invoice)
            ->with('statuses', $statuses);
    }

    public function status(Request $request, $id)
    {
        $invoice = NavInvoiceIn::find($id);
        $revenue = $invoice->revenue()->first();
        $revenue->status_id = $request->status;
        $revenue->update();

        return back();
    }

    public function massStatus(Request $request)
    {
        $invoices = [];
        foreach ($request->data as $invoice):
            $revenue = Revenue::find($invoice);
            $revenue->status_id = $request->status;
            $revenue->update();

            $invoices[].= $revenue->nav_invoice_in->invoiceNumber ?? '';
        endforeach;
        $invoices = json_encode($invoices);

        return response()->json(['success'=>'Számla: '.$invoices.' frissítve']);
    }

}
