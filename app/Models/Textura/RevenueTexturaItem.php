<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RevenueTexturaItem extends Model
{
    use HasFactory;

    protected $table = 'textura_bevetelezes_tetelek';
    protected $guarded = array();

    public function scopeLastMount($query, $x = 0)
    {
        $query->where('created_at', '>',
            date('Y-m-d', strtotime('-30 day')))
            ->limit(1000)->offset($x);
    }

    public function scopeHasItem($query, $item)
    {
        $query->where('revenue_textura_id', $item->BevetelezesID)
            ->where('raw_material_id', $item->AlapanyagID);
    }

    public function revenue_textura(){
        return $this->belongsTo(RevenueTextura::class);
    }

    public function raw_material(){
        return $this->belongsTo(RawMaterial::class);
    }

    public function setData($data)
    {
        $this->revenue_textura_id = $data->BevetelezesID;
        $this->raw_material_id = $data->AlapanyagID;
        $this->quantity = $data->Mennyiseg;
        $this->unit_id = $data->Egyseg;
        $this->netto = $data->NettoErtek;
        $this->vat = $data->AfaKulcs;
    }

}
