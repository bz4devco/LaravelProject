<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'province_id'];

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }
}
