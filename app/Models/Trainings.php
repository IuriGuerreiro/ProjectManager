<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainings extends Model
{
    use HasFactory;
    use SoftDeletes;
    

    protected $fillable = [
        'training_code',
        'training_designation',
        'status',
        'deleted_at'
    ];
}
