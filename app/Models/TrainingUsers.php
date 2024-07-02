<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingUsers extends Model
{
    use HasFactory;
    use SoftDeletes;
    

    protected $table = 'trainings_users';
    protected $fillable = [
        'train_id',
        'users_id',
        'deleted_at'
    ];
}
