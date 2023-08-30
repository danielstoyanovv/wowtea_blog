<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentApisResponseHistory extends Model
{
    use HasFactory;

    protected $table = 'payment_apis_response_history';
    protected $fillable = [
        'content',
        'response',
        'method',
        'provider',
        'provider_config'
    ];
}
