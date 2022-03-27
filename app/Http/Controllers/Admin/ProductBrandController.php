<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Product\BrandCollection;
use App\Models\ProductBrand;
use Illuminate\Http\Request;

class ProductBrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = ProductBrand::paginate($request->get('limit', 10));

        return Response::status('success')
            ->message('List of product brands')
            ->result(new BrandCollection($brands));
    }
}
