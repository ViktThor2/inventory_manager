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

class CopyAllController extends Controller
{

    public function revenues()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Bevetelezesek');
        foreach ($alls as $all):
            $r = RevenueTextura::find($all->BevetelezesID);
            if(!isset($r)):
                $revenue = new RevenueTextura();
                $revenue->setData($all);
                $revenue->save();
            endif;
        endforeach;
    }

    public function revenueItems()
    {
        $alls = DB::connection('textura')->select('select * from dbo.BevetelezesTetelek');
        foreach ($alls as $all):
            $r = RevenueTexturaItem::find($all->BevetelezesID);
            if(!isset($r)):
                $revenueItem = new RevenueTexturaItem();
                $revenueItem->setData($all);
                $revenueItem->save();
            endif;
        endforeach;
    }

    public function importers()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Beszallitok');
        foreach ($alls as $all):
            $r = Importer::find($all->BeszallitoID);
            if(!isset($r)):
                $importer = new Importer();
                $importer->setData($all);
                $importer->save();
            endif;
        endforeach;
    }

    public function rawMaterials()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Alapanyagok');
        foreach ($alls as $all):
            $r = RawMaterial::find($all->AlapanyagID);
            if(!isset($r)):
                $material = new RawMaterial();
                $material->setData($all);
                $material->save();
            endif;
        endforeach;
    }

}

/*
 *     // Kalkuláció
    public function calculates()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Kalkulacio');
        foreach ($alls as $all):
            $r = Calculate::find($all->ValasztekID);
            if(!isset($r)):
                $calculate = new Calculate();
                $calculate->setData($all);
                $calculate->save();
            endif;
        endforeach;
    }

    public function components()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Osszetevok');
        foreach ($alls as $all):
            $r = Component::find($all->OsszetevoID);
            if(!isset($r)):
                $component = new Component();
                $component->setData($all);
                $component->save();
            endif;
        endforeach;
    }

    public function groups()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Csoportok');
        foreach ($alls as $all):
            $r = Group::find($all->CsoportID);
            if(!isset($r)):
                $group = new Group();
                $group->setData($all);
                $group->save();
            endif;
        endforeach;
    }

    public function selections()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Valasztek');
        foreach ($alls as $all):
            $r = Selection::find($all->ID);
            if(!isset($r)):
                $selection = new Selection();
                $selection->setData($all);
                $selection->save();
            endif;
        endforeach;
    }

    public function units()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Egysegek');
        foreach ($alls as $all):
            $r = Unit::find($all->EgysegID);
            if(!isset($r)):
                $unit = new Unit();
                $unit->setData($all);
                $unit->save();
            endif;
        endforeach;
    }

    public function waiters()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Pincerek');
        foreach ($alls as $all):
            $r = Waiter::find($all->Id);
            if(!isset($r)):
                $waiter = new Waiter();
                $waiter->setData($all);
                $waiter->save();
            endif;
        endforeach;
    }


    public function recipes()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Recepturak');
        foreach ($alls as $all):
            $r = Recipe::find($all->RecepturaID);
            if(!isset($r)):
                $recipe = new Recipe();
                $recipe->setData($all);
                $recipe->save();
            endif;
        endforeach;
    }


    public function inventories()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Leltarak');
        foreach ($alls as $all):
            $r = Inventory::find($all->OsszetevoID);
            if(!isset($r)):
                $inventory = new Inventory();
                $inventory->setData($all);
                $inventory->save();
            endif;
        endforeach;
    }

    public function mainGroups()
    {
        $alls = DB::connection('textura')->select('select * from dbo.Focsoportok');
        foreach ($alls as $all):
            $r = MainGroup::find($all->FocsoportID);
            if(!isset($r)):
                $mainGroup = new MainGroup();
                $mainGroup->setData($all);
                $mainGroup->save();
            endif;
        endforeach;
    }


 */
