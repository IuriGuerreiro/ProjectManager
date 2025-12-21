<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formers extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'train_id',
        'deleted_at'
    ];

    /**
     * Get teams that have access to this former
     */
    public function teams()
    {
        return $this->belongsToMany(Teams::class, 'former_teams', 'former_id', 'team_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }

    /**
     * Get trainings this former is assigned to
     */
    public function trainings()
    {
        return $this->belongsToMany(Trainings::class, 'training_formers', 'former_id', 'train_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }
}
