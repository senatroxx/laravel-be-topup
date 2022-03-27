<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ref_id',
        'invoice_id',
        'invoice_url',
        'status',
        'payment_method',
        'amount',
        'balance_history_id',
        'paid_at',
        'expiry_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'paid_at' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    protected $with = [
        'balanceHistory',
    ];

    public function balanceHistory()
    {
        return $this->belongsTo(BalanceHistory::class);
    }
}
