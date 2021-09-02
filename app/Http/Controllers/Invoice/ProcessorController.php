<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\{Processor, Partner, Company, Unit};
use App\Models\Nav\{
    Nav, NavInvoiceIn, NavInvoiceInItem, NavInvoiceOut, NavInvoiceOutItem
};
use App\Models\Textura\{
    Calculate, Component, Group, Importer, Inventory, MainGroup, RawMaterial,
    Recipe, Revenue, RevenueTexturaItem, Selection, Traffic, Waiter,
};
class ProcessorController extends Controller
{
    public function index()
    {
        $navInvoice = NavInvoiceIn::find(1737);
        $navItems = $navInvoice->nav_invoice_in_items()->get();
        $texturaInvoice = Revenue::TexturaInvoice($navInvoice->invoiceNumber)->first();
        $texturaItems = $texturaInvoice->revenue_items()->get();
        foreach ($texturaItems as $texturaItem):
            $texturaRawMaterial[] = $texturaItem->raw_material()->get();
        endforeach;

        $processor = new Processor();
        $diff = $processor->itemDiff($navInvoice, $texturaInvoice);
        foreach ($diff as $d):
            $differencia[] = NavInvoiceInItem::find($d);
        endforeach;

        return view('invoice.processor')
            ->with('navInvoice', $navInvoice)
            ->with('texturaInvoice', $texturaInvoice)
            ->with('differencia', $differencia);

    }
}
