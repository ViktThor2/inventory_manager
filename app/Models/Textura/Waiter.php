<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waiter extends Model
{
    use HasFactory;

    protected $table = 'textura_pincerek';
    protected $guarded = array();

    public function setData($data)
    {
        $this->id = $data->Id;
        $this->name = $data->Nev;
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }
}
