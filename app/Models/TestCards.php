<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCards extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'card_number',
        'expiry_month',
        'expiry_year',
        'security_code',
        'holder_name',
        'provider'
    ];
}
