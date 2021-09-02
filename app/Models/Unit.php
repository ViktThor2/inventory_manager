<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'unit';
    protected $guarded = array();

    public function setData($data)
    {
        $this->id = $data->EgysegID;
        $this->name = $data->Nev;
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }
}
