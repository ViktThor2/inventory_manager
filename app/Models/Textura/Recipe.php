<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'textura_recepturak';
    protected $guarded = array();

    public function setData($data)
    {
        $this->id = $data->RecepturaID;
        $this->component_id = $data->OsszetevoID;
        $this->name = $data->Nev;
        $this->quantity = $data->Mennyiseg;
        $this->unit_id = $this->unit($data->Egyseg);
        $this->elabe = $data->ELABE;
    }

    public function unit($data)
    {
        $units = Unit::all();
        foreach ($units as $unit):
            if($data == $unit->name):
                return $unit->id;
            endif;
        endforeach;
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }
}
