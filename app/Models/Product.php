<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'seller_name',
        'sku_code',
        'price',
        'margin',
        'status',
        'seller_status',
        'unlimited_stock',
        'stock',
        'multi',
        'start_cut_off',
        'end_cut_off',
        'product_category_id',
        'product_brand_id',
        'product_type_id',
    ];

    protected $with = [
        'category',
        'brand',
        'type',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->margin = 0;
        });
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'product_brand_id');
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function availableProductsByCategory($value)
    {
        return $this->where('product_category_id', $value)
            ->whereStatus(1)
            ->whereSellerStatus(1)
            ->where('margin', '>', 0)
            ->get();
    }

    public function getAvailableProduct($value)
    {
        return $this->whereStatus(1)
            ->whereSellerStatus(1)
            ->whereId($value)
            ->where('margin', '>', 0);
    }
}
