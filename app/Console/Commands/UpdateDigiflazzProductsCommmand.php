<?php

namespace App\Console\Commands;

use App\Helpers\Digiflazz;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductType;
use Illuminate\Console\Command;

class UpdateDigiflazzProductsCommmand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'digiflazz:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update digiflazz products';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Digiflazz::getPriceList();

        foreach ($products as $product) {

            $brand = ProductBrand::firstOrCreate(
                ['name' => $product['brand']]
            );
            $type = ProductType::firstOrCreate(
                ['name' => $product['type']]
            );
            $category = ProductCategory::firstOrCreate(
                ['name' => $product['category']]
            );

            Product::updateOrCreate(
                ['sku_code' => $product['buyer_sku_code']],
                [
                    ...$product,
                    'name' => $product['product_name'],
                    'description' => $product['desc'],
                    'sku_code' => $product['buyer_sku_code'],
                    'status' => $product['buyer_product_status'],
                    'seller_status' => $product['seller_product_status'],
                    'product_brand_id' => $brand->id,
                    'product_type_id' => $type->id,
                    'product_category_id' => $category->id,
                ]
            );
        }
    }
}
