<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookResponseHistory extends Model
{
    use HasFactory;

    protected $table = 'webhook_response_history';
    protected $fillable = [
        'response',
        'eventCode',
        'provider'
    ];
}
