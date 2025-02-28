<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'username',
        'password',
        'user_id',
        'avatar'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    protected $casts = [
        'id' => 'string',
        'password' => 'hashed',
    ];

}
