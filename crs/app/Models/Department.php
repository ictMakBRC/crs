<?php

namespace App\Models;

use App\Models\User;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['department_name','description','status','created_by'];

    public function users(){
        return $this->hasMany(User::class);
     }

     public static function boot()
     {
         parent::boot();
         if(Auth::check()){
             self::creating(function ($model) 
             {
             $model->created_by = auth()->id();
             });
         }
     }
}
