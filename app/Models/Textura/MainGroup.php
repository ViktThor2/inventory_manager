<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainGroup extends Model
{
    use HasFactory;

    protected $table = 'textura_focsoportok';
    protected $guarded = array();

    public function setData($data)
    {
        $this->id = $data->FocsoportID;
        $this->name = $data->Nev;
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }
}
