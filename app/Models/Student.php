<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'joining_date',
        'leaving_date',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
