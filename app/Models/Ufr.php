<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UFR extends Model
{
    use SoftDeletes;

    protected $table = 'ufr';

    protected $guarded = ['id'];

    public function universite()
    {
        return $this->belongsTo(Universite::class);
    }

    public function departements()
    {
        return $this->hasMany(Departement::class);
    }

    public function scopeWithUniversite($query)
    {
        return $query->with('universite');
    }

    public function scopeWithDepartements($query)
    {
        return $query->with('departements');
    }

    protected static function booted()
    {
        static::deleting(function ($ufr) {
            foreach ($ufr->departements as $departement) {
                $departement->deleted_by = 'system';
                $departement->save();

                $departement->delete();
            };

            $ufr->deleted_by = 'system';
            $ufr->save();
        });
    }
}
