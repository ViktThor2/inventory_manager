<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statuses extends Model
{
    use HasFactory;

    protected $table = 'statuses';

    public function revenues()
    {
        return $this->belongsToMany(Revenue::class);
    }

    public function revenue_items()
    {
        return $this->hasMany(RevenueItem::class);
    }

}
