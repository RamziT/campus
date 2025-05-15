<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Niveau extends Model
{
    use SoftDeletes;

    protected $table = 'niveaux';

    protected $guarded = ['id'];

    protected $casts = [
        'accessible' => 'boolean',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
    public function diplomes()
    {
        return $this->belongsToMany(Diplome::class, 'niveaux_diplomes', 'niveau_id', 'diplome_id')
            ->withPivot('created_by', 'updated_by')
            ->withTimestamps();;
    }

    public function scopeWithFiliere($query)
    {
        return $query->with('filiere');
    }

    public function scopeWithDiplomes($query)
    {
        return $query->with('diplomes');
    }

    protected static function booted()
    {
        static::deleting(function ($niveau) {
            $niveau->diplomes()->detach();

            $niveau->deleted_by = 'system';
            $niveau->save();
        });
    }
}
