<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public const STATUS_NONE = 'NONE';
    public const STATUS_QUEUED = 'QUEUED';
    public const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    public const STATUS_FAILED = 'FAILED';
    public const STATUS_COMPLETED = 'COMPLETED';

    protected $fillable = [
        'user_id',
        'title',
        'group_id',
        'audiofile',
        'job',
        'speakers',
        'status'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string',
        'group_id' => 'integer',
        'audiofile' => 'string',
        'job' => 'string',
        'speakers' => 'integer',
        'status' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function transcribes()
    {
        return $this->hasMany(Transcribe::class);
    }
}
