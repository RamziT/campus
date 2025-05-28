<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Departement extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'departements';

    protected $guarded = [ 'id' ];

    public function ufr()
    {
        return $this->belongsTo(UFR::class, 'ufr_id', 'id');
    }

    public function filieres()
    {
        return $this->hasMany(Filiere::class, 'departement_id', 'id');
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
                $filiere->delete();
            };

            $departement->statut = 'inactive';
            $departement->updated_by = 'system';
            $departement->deleted_by = 'system';
            $departement->save();
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('diplome');
    }
}
