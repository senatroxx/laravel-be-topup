<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Product\TypeCollection;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = ProductType::paginate($request->get('limit', 10));

        return Response::status('success')
            ->message('List of product types')
            ->result(new TypeCollection($types));
    }
}
