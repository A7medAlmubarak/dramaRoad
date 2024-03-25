<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PollLike extends Model
{
    use HasFactory;
    protected $fillable = [
        'like_status',
        'user_id',
        'poll_id',
        'date',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
        }

}
