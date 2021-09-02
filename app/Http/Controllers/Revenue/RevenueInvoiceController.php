<?php

namespace App\Http\Controllers\Revenue;

use App\Models\{Company, Partner, Revenue, RevenueItem, Statuses, Textura\RevenueTextura};
use App\Models\Textura\{Importer};
use App\Models\Nav\NavInvoiceIn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RevenueInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $texturas = RevenueTextura::all();
        $companies = Company::all();
        $statuses = Statuses::all();
        $partners = Partner::all();
        $importers = Importer::all();

        if ($request->isMethod('post')){
            $search = $request->all();
        } elseif (session('search')) {
            $search = session()->get('search');
        } else {
            $search['PriceMin'] = null;
            $search['PriceMax'] = null;
            $search['company'] = null;
            $search['partner'] = null;
            $search['invoiceNumber'] = null;
            $search['fromDate'] = date('Y-m-d', strtotime('-30 day'));
            $search['toDate'] = date("Y-m-d");
        }

        if(isset($search)):
            $invoices = NavInvoiceIn::SearchInvocing($search)->get();
            foreach ($invoices as $key => $invoice):
                $invoice->setInvocingIndex();
                if (isset($request->status)):
                    if ($invoice->searchStatus(1) != true):
                        unset($invoices[$key]);
                    endif;
                endif;
            endforeach;
            session()->put('search', $search);
        endif;


        $searchRevenue['PriceMin'] = null;
        $searchRevenue['PriceMax'] = null;
        $searchRevenue['importer'] = null;
        $searchRevenue['invoiceNumber'] = null;
        $searchRevenue['fromDate'] = date('Y-m-d', strtotime('-30 day'));
        $searchRevenue['toDate'] = date("Y-m-d");

        return view('revenue.pair')
            ->with('revenues', $invoices)
            ->with('texturas', $texturas)
            ->with('companies', $companies)
            ->with('statuses', $statuses)
            ->with('partners', $partners)
            ->with('importer', $importers)
            ->with('search', $search);
    }

}
