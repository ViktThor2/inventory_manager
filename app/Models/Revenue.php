<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Nav\NavInvoiceIn;
use App\Models\Textura\RevenueTextura;

class Revenue extends Model
{
    use HasFactory;

    protected $table = 'revenues';
    protected $guarded = array();

    public function scopeNewRevenue($query)
    {
        $query->where('revenue_textura_id', '>', 0)
            ->whereBetween('status_id', [1, 10]);
    }

    public function scopeNotPair($query)
    {
        $query->where('revenue_textura_id', 0);
    }

    public function scopeStatusNew($query)
    {
        $query->where('status_id', '1');
    }

    public function setData($nav)
    {
        $this->nav_invoice_in_id = $nav->id;
        $this->revenue_textura_id = 0;
        $this->status_id = 1;
    }

    public function setShow()
    {
        foreach ($this->revenue_items as $item):
            $this->allQty += $item->nav_invoice_in_item->quantity;
        endforeach;
    }

    public function setItem()
    {
        foreach ($this->revenue_items as $item):
            $item->revenue_item($this);
        endforeach;
    }

    public function setStatus()
    {
        $this->status_id = 4;
        foreach ($this->revenue_items as $item):
            if($item->status_id != 3 || $item->status_id != 4):
                $this->status_id = 2;
            endif;
        endforeach;

        $this->update();
    }

    public function nav_invoice_in(){
        return $this->belongsTo(NavInvoiceIn::class);
    }

    public function revenue_textura(){
        return $this->belongsTo(RevenueTextura::class);
    }

    public function status(){
        return $this->belongsTo(Statuses::class);
    }

    public function revenue_items(){
        return $this->hasMany(RevenueItem::class);
    }


}
