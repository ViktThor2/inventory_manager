<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $table = 'textura_osszetevok';
    protected $guarded = array();

    public function setData($data)
    {
        $this->id = $data->OsszetevoID;
        $this->type = $data->Tipus;
        $this->name = $data->Nev;
        $this->goup_id = $data->CsoportID;
        $this->unit_id = $data->Egyseg;
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }
}
