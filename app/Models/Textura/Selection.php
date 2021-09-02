<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    use HasFactory;

    protected $table = 'textura_valasztek';
    protected $guarded = array();

    public function setData($data)
    {
        $this->id = $data->ID;
        $this->main_group = $data->Focsoport;
        $this->category = $data->Kategoria;
        $this->name = $data->Nev;
        $this->price = $data->Ar;
        $this->active = $data->Aktiv;
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }
}
