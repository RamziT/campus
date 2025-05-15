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
        return $this->belongsTo(Departement::class);
    }

        public function niveaux()
        {
            return $this->hasMany(Niveau::class);
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
                $niveau->deleted_by = 'system';
                $niveau->save();

                $niveau->delete();
            };

            $filiere->deleted_by = 'system';
            $filiere->save();
        });
    }
}
