<?php

namespace App\Models\CRS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kit extends Model
{
    use HasFactory;
    protected $fillable = ['kit_name','platform_id'];
}
