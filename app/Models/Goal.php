<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    /** @use HasFactory<\Database\Factories\GoalFactory> */
    use HasFactory , HasUuids;

    protected $fillable = [
        'user_id',
        'amount',
        'progress',
        'checked'
    ];

    public function user(){
        $this->belongsTo(User::class);
    }


    protected $casts = [
        'id' => 'string',
    ];

}
