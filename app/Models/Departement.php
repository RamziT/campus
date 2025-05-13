<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departement extends Model
{
    use SoftDeletes;

    protected $table = 'departements';

    protected $guarded = [ 'id' ];

    public function UFR()
    {
        return $this->belongsTo(UFR::class);
    }

    public function filieres(){
        return $this->hasMany(Filiere::class);
    }
}
