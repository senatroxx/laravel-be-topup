<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Transaction\TransactionCollection;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::pagination($request->get('limit', 10));

        return Response::status('success')
            ->message('List of transactions')
            ->result(new TransactionCollection($transactions));
    }
}
