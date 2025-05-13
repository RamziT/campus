<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filiere extends Model
{
    use SoftDeletes;

    protected $table = '';

    protected $guarded = [ 'id' ];
}
