<?php

namespace App\Http\Controllers\User;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\Product\CategoryCollection;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::all();

        return Response::status('success')
            ->message('List of categories')
            ->result(new CategoryCollection($categories));
    }
}
