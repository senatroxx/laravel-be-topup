<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Invoice\InvoiceCollection;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Invoice::pagination($request->get('limit', 10));

        return Response::status('success')
            ->message('List of transactions')
            ->result(new InvoiceCollection($transactions));
    }
}
