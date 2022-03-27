<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Product\CategoryCollection;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::paginate($request->get('limit', 10));

        return Response::status('success')
            ->message('List of product categories')
            ->result(new CategoryCollection($categories));
    }
}
