<?php

namespace App\Http\Controllers\Revenue;

use App\Models\{Revenue, RevenueItem, };
use App\Models\Nav\{NavInvoiceIn, NavInvoiceInItem};
use App\Models\Textura\{RevenueTextura, };
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class RevenueDbController extends Controller
{
    public function createInvoice()
    {
        $navI = NavInvoiceIn::LastRevenue()->get();
        foreach ($navI as $nav):
            $revenue = new Revenue();
            $revenue->setData($nav);
            $revenue->save();
        endforeach;

        return redirect()->route('revenue.create.item');
    }

    public function createItem()
    {
        $navItem = NavInvoiceInItem::RevenueItemLast()->get();
        foreach ($navItem as $item):
            $revenueItem = new RevenueItem();
            $revenueItem->setData($item);
            $revenueItem->save();
        endforeach;

        return redirect()->route('revenue.create.textura.invoice');
    }

    public function texturaInvoice()
    {
        $revenueTexts = RevenueTextura::HasNoPair()->get();
        foreach ($revenueTexts as $revenueText):

            if(isset($revenueText->importer->vatCode)):

                $navInvoices = NavInvoiceIn::Importer(
                    $revenueText->date, $revenueText->importer->vatCode)->get();

                foreach ($navInvoices as $navInvoice):
                    if($navInvoice->equalInvoiceNumer($revenueText->serial_number) == true):
                        $revenue = $navInvoice->revenue()->first();
                        $revenue->revenue_textura_id = $revenueText->id;
                        $revenue->update();

                        $revenueText->has_pair = 1;
                        $revenueText->update();
                        break;
                    endif;
               endforeach;

            endif;
        endforeach;

        return redirect()->route('revenue.create.textura.item');
    }

    public function texturaItems()
    {
        $revenues = Revenue::NewRevenue()->get();

        foreach ($revenues as $revenue):

            foreach($revenue->revenue_items as $item):
                $t = $item->itemContain($revenue);
                if( $t != false ):
                    $item->revenue_textura_item_id = $t;
                    $item->status_id = 3;
                    $item->update();

                    $revenue = $item->revenue()->first();
                    $revenue->setStatus();
                endif;
            endforeach;
        endforeach;
    }

}
