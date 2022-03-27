<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BalanceHistory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'type',
        'balance_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $model->invoices()->delete();
            $model->transactions()->delete();
        });

        static::restored(function ($model) {
            $model->invoices()->restore();
            $model->transactions()->restore();
        });

        static::forceDeleted(function ($model) {
            $model->invoices()->forceDelete();
            $model->transactions()->forceDelete();
        });
    }

    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
