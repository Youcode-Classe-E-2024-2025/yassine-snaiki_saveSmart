<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable=['amount','profile_id','category_id','type'];


    public function profile(){
        return $this->belongsTo(Profile::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    protected $casts = [
        'id' => 'string',
    ];
}
