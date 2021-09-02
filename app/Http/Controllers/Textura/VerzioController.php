<?php

namespace App\Http\Controllers\Textura;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\{
    Unit,
};
use App\Models\Textura\{
    Calculate, Component, Group, Importer, Inventory, MainGroup, RawMaterial,
    Recipe, RevenueTextura, RevenueTexturaItem, Selection, Traffic, Waiter,
};

class VerzioController extends Controller
{
    public function calculates()
    {
        $calculates = Calculate::LastMount()->get();

        foreach ($calculates as $calculate ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Kalkulacio WHERE ValasztekID = $calculate->id");
            foreach ($item as $i):
                $calculate->setData($i);
                $calculate->update();
            endforeach;
        endforeach;
    }

    public function components()
    {
        $components = Component::LastMount()->get();

        foreach ($components as $component ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Osszetevok WHERE OsszetevoID = $component->id");
            foreach ($item as $i):
                $component->setData($i);
                $component->update();
            endforeach;
        endforeach;
    }

    public function groups()
    {
        $groups = Group::LastMount()->get();

        foreach ($groups as $group ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Csoportok WHERE CsoportID = $group->id");
            foreach ($item as $i):
                $group->setData($i);
                $group->update();
            endforeach;
        endforeach;
    }

    public function importers()
    {
        $importers = Importer::LastMount()->get();

        foreach ($importers as $importer ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Beszallitok WHERE BeszallitoID = $importer->id");
            foreach ($item as $i):
                $importer->setData($i);
                $importer->update();
            endforeach;
        endforeach;
    }

    public function inventories()
    {
        $inventories = Inventory::LastMount()->get();

        foreach ($inventories as $inventory ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Leltarak WHERE OsszetevoID = $inventory->id");
            foreach ($item as $i):
                $inventory->setData($i);
                $inventory->update();
            endforeach;
        endforeach;
    }

    public function mainGroups()
    {
        $mainGroups = MainGroup::LastMount()->get();

        foreach ($mainGroups as $mainGroup ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Focsoportok WHERE FocsoportID = $mainGroup->id");
            foreach ($item as $i):
                $mainGroup->setData($i);
                $mainGroup->update();
            endforeach;
        endforeach;
    }

    public function rawMaterials()
    {
        $rawMaterials = RawMaterial::LastMount()->get();

        foreach ($rawMaterials as $rawMaterial ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Alapanyagok WHERE AlapanyagID = $rawMaterial->id");
            foreach ($item as $i):
                $rawMaterial->setData($i);
                $rawMaterial->update();
            endforeach;
        endforeach;
    }

    public function recipes()
    {
        $recipes= Recipe::LastMount()->get();

        foreach ($recipes as $recipe ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Recepturak WHERE RecepturaID = $recipe->id");
            foreach ($item as $i):
                $recipe->setData($i);
                $recipe->update();
            endforeach;
        endforeach;
    }

    public function revenues()
    {
        $revenues = RevenueTextura::LastMount()->get();

        foreach ($revenues as $revenue ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Bevetelezesek WHERE BevetelezesID = $revenue->id");
            $revenue->setData($item[0]);
            $revenue->update();
            $this->revenueItems($revenue);
        endforeach;
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
    }

    public function revenueMoney()
    {
        $revenues = RevenueTextura::PaginateDB()->get();
        foreach ($revenues as $revenue):
            $revenue->setMoney();
            $revenue->update();
        endforeach;
    }

    public function selections()
    {
        $selections = Selection::LastMount()->get();

        foreach ($selections as $selection ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Valasztek WHERE ID = $selection->id");
            foreach ($item as $i):
                $selection->setData($i);
                $selection->update();
            endforeach;
        endforeach;
    }

    public function units()
    {
        $units = Unit::LastMount()->get();

        foreach ($units as $unit ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Egysegek WHERE EgysegID = $unit->id");
            foreach ($item as $i):
                $unit->setData($i);
                $unit->update();
            endforeach;
        endforeach;
    }

    public function waiters()
    {
        $waiters = Waiter::LastMount()->get();

        foreach ($waiters as $waiter ):
            $item = DB::connection('textura')
                ->select("select * from dbo.Pincerek WHERE Id = $waiter->id");
            foreach ($item as $i):
                $waiter->setData($i);
                $waiter->update();
            endforeach;
        endforeach;
    }
}
