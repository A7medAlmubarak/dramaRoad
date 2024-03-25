<?php

namespace App\Models;

use App\Models\Level;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level_id',
        'teacher_id',
        'sessions_number',
        'full_mark',
        'success_mark',
        'fail_mark',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

}
