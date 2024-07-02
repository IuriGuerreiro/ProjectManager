<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmStatus extends Model
{
    use HasFactory;
    
    protected $table = 'pm_status';

    protected $fillable = [
        'status_designation',
        'status_destination',
        'status_stage',

    ];
}
