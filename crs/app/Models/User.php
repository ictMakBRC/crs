<?php

namespace App\Models;

use App\Models\Department;
use App\Models\ActivityLog;
use App\Models\CRS\Facility;
use App\Models\Designation;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'emp_no',
        'surname',
        'first_name',
        'other_name',
        'name',
        'email',
        'password',
        'contact',
        'title',
        'is_active',
        'facility_id',
        'department_id',
        'designation_id',
        'avatar',
        'signature',
        'created_by'
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   
    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function designation(){
        return $this->belongsTo(Designation::class);
    }
   
    public function activityLogs(){
        return $this->hasMany(ActivityLog::class);
    }
    public function facility(){
        return $this->belongsTo(Facility::class,'facility_id','id');
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
