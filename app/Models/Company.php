<?php

namespace App\Models;

use App\Models\Nav\NavInvoiceIn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';
    protected $guarded = array();

    public function getData()
    {
        return static::orderBy('created_at','desc')->get();
    }

    public function storeData($input)
    {
        return static::create($input);
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function updateData($id, $input)
    {
        return static::find($id)->update($input);
    }

    public function deleteData($id)
    {
        return static::find($id)->delete();
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function nav_invoice_in(){
        return $this->hasOne(NavInvoiceIn::class);
    }

}
