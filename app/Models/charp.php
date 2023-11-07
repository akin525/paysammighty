<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class charp extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'username',
        'payment_ref',
        'amount',
        'iwallet',
        'fwallet',
        'description',
    ];
}
