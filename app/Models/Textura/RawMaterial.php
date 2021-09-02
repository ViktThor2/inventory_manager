<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RawMaterial extends Model
{
    use HasFactory;

    protected $table = 'textura_alapanyagok';
    protected $guarded = array();

    public function setData($data)
    {
        $this->id = $data->AlapanyagID;
        $this->name = $data->Nev;
        $this->group_id = $data->CsoportID;
        $this->unit_id = $data->Egyseg;
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }

    public function revenue_items()
    {
        return $this->hasMany(RevenueTexturaItem::class);
    }


}
