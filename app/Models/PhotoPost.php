<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'photo',
        'likes',
        'deslikes',
        'date',
    ];

}
