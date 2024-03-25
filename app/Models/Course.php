<?php

namespace App\Models;

use App\Models\Level;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'online_status',
        'registration_start_date',
        'registration_end_date',
        'students_number',
        'payments',
        'levels_number',
        'creator_id',
        'publish_status',
        'finished_status'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id' );
    }

    public function levels()
    {
        return $this->hasMany(Level::class);
    }
}
