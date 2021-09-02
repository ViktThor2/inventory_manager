<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traffic extends Model
{
    use HasFactory;

    protected $table = 'textura_forgalom';
    protected $guarded = array();

    public function setData($data)
    {
        $this->date = $data->Datum;
        $this->selection_id = $data->ValasztekID;
        $this->name = $data->Nev;
        $this->quantity = $data->Mennyiseg;
        $this->price = $data->Ar;
        $this->concession = $data->Engedmeny;
        $this->waiter_id = $data->Pincerid;
        $this->time = $data->Ido;
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }
}
