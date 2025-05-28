<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UFR extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'ufr';

    protected $guarded = ['id'];

    public function universite()
    {
        return $this->belongsTo(Universite::class, 'universite_id', 'id');
    }

    public function departements()
    {
        return $this->hasMany(Departement::class, 'ufr_id', 'id');
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
                $departement->delete();
            };

            $ufr->statut = 'inactive';
            $ufr->updated_by = 'system';
            $ufr->deleted_by = 'system';
            $ufr->save();
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
