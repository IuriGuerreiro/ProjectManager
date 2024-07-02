<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingFormers extends Model
{
    use HasFactory;
    use SoftDeletes;
     

    protected $fillable = [
        'train_id',
        'former_id',
        'deleted_at'
    ];
}
