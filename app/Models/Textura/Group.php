<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'textura_csoportok';
    protected $guarded = array();

    public function setData($data)
    {
        $this->id = $data->CsoportID;
        $this->name = $data->Nev;
        $this->main_group_id = $data->FocsoportID;
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }
}
