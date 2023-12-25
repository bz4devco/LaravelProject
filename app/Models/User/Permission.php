<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        
    ];


    public function roles() {
        return $this->belongsToMany('App\Models\User\Role');
    }
}
