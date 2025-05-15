<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departement extends Model
{
    use SoftDeletes;

    protected $table = 'departements';

    protected $guarded = [ 'id' ];

    public function ufr()
    {
        return $this->belongsTo(UFR::class);
    }

    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }

    public function scopeWithUfr($query)
    {
        return $query->with('ufr');
    }

    public function scopeWithFilieres($query)
    {
        return $query->with('filieres');
    }

    protected static function booted()
    {
        static::deleting(function ($departement) {
            foreach ($departement->filieres as $filiere) {
                $filiere->deleted_by = 'system';
                $filiere->save();

                $filiere->delete();
            };

            $departement->deleted_by = 'system';
            $departement->save();
        });
    }
}
