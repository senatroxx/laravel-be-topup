<?php

namespace App\Http\Controllers\User;

use App\Helpers\Digiflazz;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Transaction\PurchaseRequest;
use App\Http\Resources\User\Transaction\TransactionCollection;
use App\Http\Resources\User\Transaction\TransactionResource;
use App\Models\BalanceHistory;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('balanceHistory')->latest()->paginate($request->get('limit', 10));

        return Response::status('success')
            ->message('List of transactions')
            ->result(new TransactionCollection($transactions));
    }

    public function show(Transaction $authenticatedTransaction)
    {
        $authenticatedTransaction->load('balanceHistory');

        return Response::status('success')
            ->message('Transaction detail')
            ->result(new TransactionResource($authenticatedTransaction));
    }

    public function purchase(PurchaseRequest $request)
    {
        $attributes = $request->validated();

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($attributes['product_id']);
            $response = Digiflazz::purchase($product, $attributes);
            $amount = $product->price + $product->margin;

            if (Digiflazz::translateStatus($response['status']) != 'FAILED') {
                $request->user()->balance()->decrement('amount', $amount);
            }

            $balanceHistory = BalanceHistory::create([
                'amount' => $amount,
                'type' => 'BUY',
                'balance_id' => $request->user()->balance->id,
            ]);

            $transaction = Transaction::create([
                ...$response,
                'status' => Digiflazz::translateStatus($response['status']),
                'product' => $product->name,
                'sku_code' => $response['buyer_sku_code'],
                'response_code' => $response['rc'],
                'serial_number' => $response['sn'],
                'amount' => $amount,
                'balance_history_id' => $balanceHistory->id,
            ]);
            $transaction->load('balanceHistory');

            DB::commit();
        } catch (\Throwable$th) {
            DB::rollback();

            return Response::status('failed')
                ->code($th->getCode() ?? 500)
                ->message("Something went wrong")
                ->result(!app()->isProduction() ? "$th" : null);
        }
        return Response::status('success')
            ->message("Success purchased $product->name!")
            ->result(new TransactionResource($transaction));
    }

    public function callback(Request $request)
    {
        $attributes = $request->all();
        $transaction = Transaction::with('balanceHistory.balance')->where('ref_id', $attributes['data']['ref_id'])->first();

        if (Digiflazz::translateStatus($attributes['data']['status']) == 'FAILED') {
            $transaction->balanceHistory->balance()->increment('amount', $transaction->amount);
        }
        $transaction->status = Digiflazz::translateStatus($attributes['data']['status']);
        $transaction->response_code = $attributes['data']['rc'];
        $transaction->save();

    }
}
