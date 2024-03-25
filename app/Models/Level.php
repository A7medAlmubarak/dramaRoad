<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'shift_type',
        'school_schedule',
        'level_number',
        'completed',
        'course_id',
        'finished_status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($level) {
            $level->level_number = $level->course->levels->count() +1;
            $level->course->levels_number = $level->course->levels_number +1;
            $level->course->save();
        });

        static::deleting(function ($level) {
            $levels = $level->course->levels->sortBy('level_number');
            $level = $levels->where('id', $level->id)->first();

            // Decrease the level number of all the levels below the deleted level
            $i = $level->level_number;
            foreach ($levels as $l) {
                if ($l->level_number >= $level->level_number) {
                    $l->level_number = $i;
                    $l->save();
                    }
                }
            // Decrease the course's total levels number
            $level->course->levels_number=$level->course->levels_number-1;
            $level->course->save();
        });
    }


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

}
