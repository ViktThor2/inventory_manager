<?php

namespace App\Models;

use App\Models\Nav\NavInvoiceInItem;
use App\Models\Textura\{RawMaterial, RevenueTexturaItem};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RevenueItem extends Model
{
    use HasFactory;

    protected $table = 'revenue_items';

    public function setShow()
    {
        $this->status = $this->status->name;
    }

    // A Textura bevételezés tételének első szavát hasonlítja a számla táteláhez
    public function itemContain($revenue)
    {
        foreach ($revenue->revenue_textura->revenue_textura_items as $texturaItem):
            if(isset($texturaItem->raw_material->name)):

                // Nagybetűre alakítja az első szót (Textúra alapanyag)
                $texturaItemName = strtok($texturaItem->raw_material->name, " ");

                // Nav számla tétel nevében keresi Textúra alapanyagot
                if(strpos($this->nav_invoice_in_item->lineDescription, $texturaItemName) != false):
                    return $texturaItem->id;
                endif;

            endif;
        endforeach;

        return  false;
    }

    public function raw_material(){
        return $this->belongsTo(RawMaterial::class);
    }

    public function revenue(){
        return $this->belongsTo(Revenue::class);
    }

    public function nav_invoice_in_item(){
        return $this->belongsTo(NavInvoiceInItem::class);
    }

    public function revenue_textura_item(){
        return $this->belongsTo(RevenueTexturaItem::class);
    }

    public function status(){
        return $this->belongsTo(Statuses::class);
    }

    public function setData($item)
    {
        $this->revenue_id = $item->nav_invoice_in->revenue->id;
        $this->nav_invoice_in_item_id = $item->id;
        $this->revenue_textura_item_id = 0;
        $this->status_id = 1;
    }

}
