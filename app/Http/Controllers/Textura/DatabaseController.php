<?php

namespace App\Http\Controllers\Textura;

use Illuminate\Support\Facades\DB;
use App\Models\{Partner};
use App\Models\Textura\{Importer, RevenueTextura, RevenueTexturaItem};
use App\Http\Controllers\Controller;


class DatabaseController extends Controller
{

    public function revenues()
    {
        $revenues = RevenueTextura::LastMount()->get();

        // Version
        foreach ($revenues as $revenue ):
            $revenue->version();
        endforeach;

        // New
        $last = $revenues->last();
        $items = $last->newRevenue();

        foreach ($items as $item):
            $revenue = new RevenueTextura();
            $revenue->setData($item);
            $revenue->save();
            $revenues[] = $revenue;
        endforeach;

/*
        // Check
        if($revenues[0]->checkDiff($revenues->count()) == true):
            $myIDs = [];
            foreach ($revenues as $revenue):
                $myIDs[] = $revenue->id;
            endforeach;

            $diff = $revenue->getDifferences($myIDs);
        endif;
*/
        return redirect()->route('textura.revenue.items');
    }

    public function revenueItems()
    {
        $revenues = RevenueTextura::LastMount()->get();
        foreach ($revenues as $revenue ):

            $items = DB::connection('textura')
                ->select("select * from dbo.BevetelezesTetelek WHERE BevetelezesID = $revenue->id");

            foreach ($items as $item):
                // Megvizsgája létezik -e
                $texturaItem = RevenueTexturaItem::HasItem($item)->first();

                if( !isset($texturaItem) ):
                    $texturaItem = new RevenueTexturaItem();
                endif;
                $texturaItem->setData($item);
                $texturaItem->save();
            endforeach;
        endforeach;

        return redirect()->route('textura.revenue.items.new');
    }

    public function newRevenueItems()
    {
        $last = RevenueTexturaItem::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.BevetelezesTetelek WHERE BevetelezesID > $last->id");

        foreach ($item as $i):
            $revenueItem = new RevenueTexturaItem();
            $revenueItem->setData($i);
            $revenueItem->save();
        endforeach;

        return redirect()->route('revenue.create.invoice');
    }

    public function copyAll()
    {
        $CopyAllController = new CopyAllController();
        $CopyAllController->revenues();
//        $CopyAllController->revenueItems();
//        $CopyAllController->importers();
//        $CopyAllController->rawMaterials();
    }

}


/*
    public function dataNew()
    {
        $newController = new NewController();
        $newController->importers();
        $newController->rawMaterials();
        $newController->revenues();
        $newController->revenueItems();
    }

    public function dataVerzio()
    {
        $verzioController = new VerzioController();
//        $verzioController->importers();
//        $verzioController->rawMaterials();
        $verzioController->revenues();
//        $verzioController->revenueMoney();
//        $verzioController->revenueItems();
    }

    public function importer()
    {
        $importers = Importer::all();
        foreach ($importers as $importer):
            $partner = Partner::TexturaImporter($importer)->first();
            if(isset($partner)):
                $importer->partner_id = $partner->id;
                $importer->vatCode = $partner->supplierTaxNumber;
                $importer->update();
            endif;
        endforeach;
    }
*/
