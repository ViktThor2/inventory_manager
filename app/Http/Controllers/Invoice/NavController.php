<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\{Partner, Company};
use App\Models\Nav\{
    Nav, NavInvoiceIn, NavInvoiceInItem, NavInvoiceOut, NavInvoiceOutItem
};

class NavController extends Controller
{
    public function invoiceIn()
    {
        $companies = Company::all();
        foreach ($companies as $company)
        {
            $nav = new Nav();
            $reporter = $nav->token($company);
            $invoice = $nav->invoices($reporter);

            foreach ($invoice->invoiceDigest as $digest)
            {
                $json = json_encode($digest);
                $data = json_decode($json, true);

                // Számla beállítása
                $inv = DB::table('nav_invoice_in')->where('transactionId', $data['transactionId'])->get();
                if( count($inv) == 0) {
                    $nav_invoice_in = new NavInvoiceIn();
                    $nav_invoice_in->company_id = $company->id;
                    $nav_invoice_in->setData($data);
                    $nav_invoice_in->save();
                }

                // Partner beállítása
                $p = DB::table('partners')->where('supplierTaxNumber', $data['supplierTaxNumber'])->get();
                if( count($p) == 0) {
                    $partner = new Partner();
                    $partner->setData($data);
                    $partner->save();
                }
            }
            sleep(5);
        }

        return redirect()->route('invoiceInItem');
    }

    public function invoiceInItem()
    {
        // Olyan számla le kérése, aminek még nincs tétele
        $invs = NavInvoiceIn::HaveItem()->get();
        foreach ($invs as $inv):
            $company = Company::find($inv->company_id);

            $nav = new Nav();
            $reporter = $nav->token($company);
            $data = $nav->invoiceLines($reporter, $inv);

            // Partner adatok beállítása
            $partner = new Partner();
            $supplier = $partner->getSupplier($data);
            $partner->getTax($supplier);
            if(isset($partner->tax)):
                $p = $partner->hasTax()->first();
                $partner = (isset($p) ? $p : $partner);
            endif;
            $partner->setItem($supplier);
            $partner->update();


            // Számla tételeinek beállítása
            foreach ($data->invoiceMain->invoice->invoiceLines->line as $line):
                $json = json_encode($line);
                $data = json_decode($json, true);

                $nav_invoice_in_items = new NavInvoiceInItem();
                $nav_invoice_in_items->setData($data, $inv);
                $nav_invoice_in_items->save();
            endforeach;

                $inv->have_items = 1;
                $inv->update();
        endforeach;

        return redirect()->route('revenue.create.invoice');
    }

    public function invoiceOut()
    {
        $companies = Company::all();
        foreach ($companies as $company)
        {
            $nav = new Nav();
            $reporter = $nav->token($company);
            $invoice = $nav->invoicesOut($reporter);

            foreach ($invoice->invoiceDigest as $digest)
            {
                $json = json_encode($digest);
                $data = json_decode($json, true);

                $inv = DB::table('nav_invoice_out')->where('transactionId', $data['transactionId'])->get();

                if( count($inv) == 0) {
                    $nav_invoice_out = new NavInvoiceOut();
                    $nav_invoice_out->company_id = $company->id;
                    $nav_invoice_out->setData($data);
                    $nav_invoice_out->save();
                }
            }
            sleep(5);
        }

        return redirect()->route('invoiceOutItem');
    }

    public function invoiceOutItem()
    {
        $invs = DB::table('nav_invoice_out')->where('have_items', '0')->get();
        if(count($invs) > 0):
            foreach ($invs as $inv):
                $company = Company::find($inv->company_id);

                $nav = New Nav();
                $reporter = $nav->token($company);
                $data = $nav->invoiceLinesOut($reporter, $inv);

                foreach($data->invoiceMain->invoice->invoiceLines->line as $line):
                    $json = json_encode($line);
                    $data = json_decode($json, true);

                    $nav_invoice_out_items = new NavInvoiceOutItem();
                    $nav_invoice_out_items->company_id = $inv->company_id;
                    $nav_invoice_out_items->transactionId = $inv->invoiceNumber;
                    $nav_invoice_out_items->nav_invoice_out_id = $inv->id;

                    $nav_invoice_out_items->setData($data, $inv);
                    $nav_invoice_out_items->save();
                endforeach;

                $inv_item = DB::table('nav_invoice_out_item')->where('invoiceNumber', $inv->invoiceNumber)->get();
                if( count($inv_item ) > 0) {
                    $invoice_out = NavInvoiceOut::find($inv->id);
                    $invoice_out->have_items = 1;
                    $invoice_out->update();
                }

            endforeach;
        endif;
    }

}
