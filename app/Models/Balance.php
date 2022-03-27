<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $model->user()->delete();
            $model->balanceHistories()->delete();
        });

        static::restored(function ($model) {
            $model->user()->restore();
            $model->balanceHistories()->restore();
        });

        static::forceDeleted(function ($model) {
            $model->user()->forceDelete();
            $model->balanceHistories()->forceDelete();
        });
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function balanceHistories()
    {
        return $this->hasMany(BalanceHistory::class);
    }
}
