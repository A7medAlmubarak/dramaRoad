<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moderator extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'date',
        'salary',
        'employment_date',
        'resignation_date',
        'vacations',
        'rewards',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
