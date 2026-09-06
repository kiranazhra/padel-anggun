<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    protected $fillable = ['type', 'text', 'data', 'read_at'];
}
