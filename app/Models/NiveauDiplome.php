<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class NiveauDiplome extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'niveaux_diplomes';

    protected $guarded = [ 'id' ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('niveau_diplome');
    }
}
