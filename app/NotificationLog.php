<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $table = 'notifications_log';

    protected $fillable = [
        'type',
        'message',
        'email',
        'phone',
        'status_code',
        'response',
    ];

    protected $casts = [
        'response' => 'array',
    ];
}
