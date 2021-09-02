<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Importer extends Model
{
    use HasFactory;

    protected $table = 'textura_beszallitok';
    protected $guarded = array();

    public function setData($data)
    {
        $this->id = $data->BeszallitoID;
        $this->name = $data->Nev;
        $this->postalCode = $data->Iranyitoszam;
        $this->city = $data->Varos;
        $this->street = $data->Utca;
        $this->vatCode = $data->Adoszam;
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }

    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }}
