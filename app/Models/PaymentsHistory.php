<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentsHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'customer',
        'date'
    ];
}
