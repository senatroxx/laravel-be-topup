<?php

namespace App\Http\Controllers\User\Xendit;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Invoice\CreateRequest;
use App\Http\Resources\User\Invoice\InvoiceCollection;
use App\Http\Resources\User\Invoice\InvoiceResource;
use App\Models\BalanceHistory;
use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Xendit\Invoice as XenditInvoice;
use Xendit\Xendit;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::whereHas('balanceHistory.balance.user', function ($query) {
            $query->where('id', auth('user-api')->user()->id);
        })->latest()->paginate($request->get('limit', 10));

        return Response::status('success')
            ->message('Invoice list')
            ->result(new InvoiceCollection($invoices));
    }

    public function store(CreateRequest $request)
    {
        $attributes = $request->validated();

        DB::beginTransaction();
        try {
            Xendit::setApiKey(config('xendit.key'));

            $refId = InvoiceRepository::generateRefId();
            $xenditPayload = [
                'external_id' => $refId,
                'amount' => $attributes['amount'],
                'description' => "Topup saldo " . config('app.name') . " sebesar Rp. {$attributes['amount']}",
                'customer' => [
                    'given_names' => "{$request->user()->first_name} {$request->user()->last_name}",
                    'email' => $request->user()->email,
                    'mobile_number' => $request->user()->phone_number,
                ],
                'invoice_duration' => config('xendit.invoice_duration'),
                'success_redirect_url' => config('xendit.success_redirect_url'),
                'failure_redirect_url' => config('xendit.failure_redirect_url'),
                'payment_methods' => InvoiceRepository::paymentChannels(),
                'currency' => 'IDR',
            ];

            $response = XenditInvoice::create($xenditPayload);

            $balanceHistory = BalanceHistory::create([
                'amount' => $attributes['amount'],
                'type' => 'TOPUP',
                'balance_id' => $request->user()->balance->id,
            ]);

            $invoice = Invoice::create([
                ...$response,
                'ref_id' => $response['external_id'],
                'invoice_id' => $response['id'],
                'balance_history_id' => $balanceHistory->id,
                'expiry_date' => new DateTime($response['expiry_date']),
            ]);

            DB::commit();
        } catch (\Throwable$th) {
            DB::rollBack();

            return Response::status('failed')
                ->code($th->getCode() ?? 500)
                ->message("Something went wrong")
                ->result(!app()->isProduction() ? "$th" : null);
        }

        return Response::status('success')
            ->message('Invoice created')
            ->result(new InvoiceResource($invoice));
    }

    public function show(Invoice $authenticatedInvoice)
    {
        return Response::status('success')
            ->message('Invoice detail')
            ->result(new InvoiceResource($authenticatedInvoice));
    }

    public function callback(Request $request)
    {
        $attributes = $request->all();

        $invoice = Invoice::with('balanceHistory.balance')
            ->where('invoice_id', $attributes['id'])
            ->first();

        if ($invoice) {
            $invoice->status = $attributes['status'];
            if ($attributes['status'] == 'PAID') {
                $invoice->paid_at = new dateTime($attributes['paid_at']);
                $invoice->payment_method = $attributes['payment_channel'];
                $invoice->balanceHistory->balance()->increment('amount', $invoice->amount);
            }
            $invoice->save();
        }

        return Response::status('success')
            ->message('Callback accepted successfully')
            ->result();
    }
}
