<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ref_id',
        'product',
        'customer_no',
        'sku_code',
        'serial_number',
        'status',
        'amount',
        'response_code',
        'balance_history_id',
    ];

    public function balanceHistory()
    {
        return $this->belongsTo(BalanceHistory::class);
    }
}
