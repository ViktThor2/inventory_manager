<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'textura_leltarak';
    protected $guarded = array();
    protected $primaryKey = 'id';


    public function setData($data)
    {
        $this->id = $data->OsszetevoID;
        $this->date = $data->Datum;
        $this->unit_id = $data->Egyseg;
        $this->calculated_quantity = $data->SzamitottMennyiseg;
        $this->real_quantity = $data->TenylegesMennyiseg;
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }
}
