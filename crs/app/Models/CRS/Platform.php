<?php

namespace App\Models\CRS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;
    protected $fillable = ['platform_name','platform_range'];
}
