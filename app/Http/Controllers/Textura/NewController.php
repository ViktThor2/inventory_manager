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

class NewController extends Controller
{
    public function calculates()
    {
        $last = Calculate::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Kalkulacio WHERE ValasztekID > $last->id");

        foreach ($item as $i):
            $calculate = new Calculate();
            $calculate->setData($i);
            $calculate->save();
        endforeach;
    }

    public function components()
    {
        $last = Component::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Osszetevok WHERE OsszetevoID > $last->id");

        foreach ($item as $i):
            $component = new Component();
            $component->setData($i);
            $component->save();
        endforeach;
    }

    public function groups()
    {
        $last = Group::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Csoportok WHERE CsoportID > $last->id");

        foreach ($item as $i):
            $group = new Group();
            $group->setData($i);
            $group->save();
        endforeach;
    }

    public function importers()
    {
        $last = Importer::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Beszallitok WHERE BeszallitoID > $last->id");

        foreach ($item as $i):
            $importer = new Importer();
            $importer->setData($i);
            $importer->save();
        endforeach;
    }

    public function inventories()
    {
        $last = Inventory::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Leltarak WHERE OsszetevoID > $last->id");

        foreach ($item as $i):
            $inventory = new Inventory();
            $inventory->setData($i);
            $inventory->save();
        endforeach;
    }

    public function mainGroups()
    {
        $last = MainGroup::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Focsoportok WHERE FocsoportID > $last->id");

        foreach ($item as $i):
            $mainGroup = new MainGroup();
            $mainGroup->setData($i);
            $mainGroup->save();
        endforeach;
    }

    public function rawMaterials()
    {
        $last = RawMaterial::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Alapanyagok WHERE AlapanyagID > $last->id");

        foreach ($item as $i):
            $rawMaterial = new RawMaterial();
            $rawMaterial->setData($i);
            $rawMaterial->save();
        endforeach;
    }

    public function recipes()
    {
        $last = Recipe::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Recepturak WHERE RecepturaID > $last->id");

        foreach ($item as $i):
            $recipe = new Recipe();
            $recipe->setData($i);
            $recipe->save();
        endforeach;
    }

    public function revenues()
    {
        $last = RevenueTextura::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Bevetelezesek WHERE BevetelezesID > $last->id");

        foreach ($item as $i):
            $revenue = new RevenueTextura();
            $revenue->setData($i);
            $revenue->save();
        endforeach;
    }

    public function revenueItems()
    {
        $last = RevenueTexturaItem::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.BevetelezesTetelek WHERE BevetelezesID > $last->id");

        foreach ($item as $i):
            $revenueItem = new RevenueTexturaItem();
            $revenueItem->setData($i);
            $revenueItem->save();
        endforeach;
    }

        public function selections()
    {
        $last = Selection::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Valasztek WHERE ID > $last->id");

        foreach ($item as $i):
            $selection = new Selection();
            $selection->setData($i);
            $selection->save();
        endforeach;
    }

    public function units()
    {
        $last = Unit::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Egysegek WHERE EgysegID > $last->id");

        foreach ($item as $i):
            $unit = new Unit();
            $unit->setData($i);
            $unit->save();
        endforeach;
    }

    public function waiters()
    {
        $last = Waiter::all()->last();
        $item = DB::connection('textura')
            ->select("select * from dbo.Pincerek WHERE Id > $last->id");

        foreach ($item as $i):
            $waiter = new Waiter();
            $waiter->setData($i);
            $waiter->save();
        endforeach;
    }
}
