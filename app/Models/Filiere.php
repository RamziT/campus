<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filiere extends Model
{
    use SoftDeletes;

    protected $table = 'filieres';

    protected $guarded = [ 'id' ];

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id', 'id');
    }

        public function niveaux()
        {
            return $this->hasMany(Niveau::class, 'filiere_id', 'id');
        }

        public function scopeWithDepartement($query)
    {
        return $query->with('departement');
    }

    public function scopeWithNiveaux($query)
    {
        return $query->with('niveaux');
    }

    protected static function booted()
    {
        static::deleting(function ($filiere) {
            foreach ($filiere->niveaux as $niveau) {
                $niveau->delete();
            };

            $filiere->statut = 'inactive';
            $filiere->updated_by = 'system';
            $filiere->deleted_by = 'system';
            $filiere->save();
        });
    }
}
