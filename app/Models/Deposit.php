<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'bank',
        'owner_name',
        'response_code',
        'notes',
        'status',
    ];
}
