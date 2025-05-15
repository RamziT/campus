<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NiveauDiplome extends Model
{
    use SoftDeletes;

    protected $table = 'niveaux_diplomes';

    protected $guarded = [ 'id' ];

}
