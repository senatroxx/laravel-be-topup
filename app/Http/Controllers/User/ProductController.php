<?php

namespace App\Http\Controllers\User;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\Product\ProductCollection;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    public function index(ProductCategory $productCategory)
    {
        return Response::status('success')
            ->message('List of products by category')
            ->result(new ProductCollection($productCategory->availableProducts()->get()));
    }
}
