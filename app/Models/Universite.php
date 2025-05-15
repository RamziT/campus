<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Universite extends Model
{
    use SoftDeletes;

    protected $table = 'universites';

    protected $guarded = ['id'];

    public function ufrs()
    {
        return $this->hasMany(UFR::class);
    }

    public function scopeWithUfrs($query)
    {
        return $query->with('ufrs');
    }

    protected static function booted()
    {
        static::deleting(function ($universite) {
            foreach ($universite->ufrs as $ufr) {
                $ufr->deleted_by = 'system';
                $ufr->save();

                $ufr->delete();
            };

            $universite->deleted_by = 'system';
            $universite->save();
        });
    }
}
