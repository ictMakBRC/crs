<?php

namespace App\Models\CRS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityTrail extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'wagonjwa_id', 'lab_no', 'event'];
}
