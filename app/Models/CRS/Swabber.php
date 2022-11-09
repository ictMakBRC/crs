<?php

namespace App\Models\CRS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Swabber extends Model
{
    use HasFactory;

    protected $fillable = ['full_name', 'status', 'facility_id', 'swabber_contact', 'swabber_email', 'created_by'];

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
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
