<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
