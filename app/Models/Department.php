<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['department_name', 'description', 'status', 'created_by'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

     public static function boot()
     {
         parent::boot();
         if (Auth::check()) {
             self::creating(function ($model) {
                 $model->created_by = auth()->id();
             });
         }
     }
}
