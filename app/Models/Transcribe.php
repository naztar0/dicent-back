<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transcribe extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'speaker',
        'content'
    ];

    protected $casts = [
        'project_id' => 'integer',
        'speaker' => 'string',
        'content' => 'string'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
