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
        return $this->hasMany(UFR::class, 'universite_id', 'id');
    }

    public function scopeWithUfrs($query)
    {
        return $query->with('ufrs');
    }

    protected static function booted()
    {
        static::deleting(function ($universite) {
            foreach ($universite->ufrs as $ufr) {
                $ufr->delete();
            };

            $universite->statut = 'inactive';
            $universite->updated_by = 'system';
            $universite->deleted_by = 'system';
            $universite->save();
        });
    }
}
