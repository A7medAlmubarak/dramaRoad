<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvertisementComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'user_id',
        'date',
        'advertisement_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }


}
