<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UFR extends Model
{
    use SoftDeletes;

    protected $table = 'ufr';

    protected $guarded = [ 'id' ];

    public function universite(){
        return $this->belongsTo(Universite::class);
    }

    public function departements(){
        return $this->hasMany(Departement::class);
    }
}
