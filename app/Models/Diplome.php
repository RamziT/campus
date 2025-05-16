<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diplome extends Model
{
    use SoftDeletes;

    protected $table = 'diplomes';

    protected $guarded = [ 'id' ];

    public function niveaux()
        {
            return $this->belongsToMany(Niveau::class, 'niveaux_diplomes', 'diplome_id', 'niveau_id');
        }

        public function scopeWithNiveaux($query)
    {
        return $query->with('niveaux');
    }

    protected static function booted()
    {
        static::deleting(function ($diplome) {
            $diplome->niveaux()->detach();

            $diplome->statut = 'inactive';
            $diplome->updated_by = 'system';
            $diplome->deleted_by = 'system';
            $diplome->save();
        });
    }
}
