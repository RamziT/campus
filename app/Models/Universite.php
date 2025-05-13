<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Universite extends Model
{
    use SoftDeletes;

    protected $table = 'universites';

    protected $guarded = [ 'id' ];

    /**
     * UFR
     *
     * @return void
     */
    public function UFRs()
    {
        return $this->hasMany(UFR::class);
    }
}
