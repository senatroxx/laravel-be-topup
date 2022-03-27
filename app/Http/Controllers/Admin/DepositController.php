<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Digiflazz;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Deposit\CreateRequest;
use App\Http\Requests\Admin\Deposit\UpdateRequest;
use App\Http\Resources\Admin\Deposit\DepositCollection;
use App\Http\Resources\Admin\Deposit\DepositResource;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        $deposits = Deposit::paginate($request->get('limit', 10));

        return Response::status('success')
            ->message('List of deposits')
            ->result(new DepositCollection($deposits));
    }

    public function show(Deposit $deposit)
    {
        return Response::status('success')
            ->message('Deposit details')
            ->result(new DepositResource($deposit));
    }

    public function store(CreateRequest $request)
    {
        $attributes = $request->validated();

        DB::beginTransaction();
        try {
            $response = Digiflazz::deposit($attributes);
            $deposit = Deposit::create([
                ...$response,
                'status' => 'PENDING',
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
            ->message('Deposit created')
            ->result(new DepositResource($deposit));
    }

    public function update(Deposit $deposit, UpdateRequest $request)
    {
        $attributes = $request->validated();

        $deposit->update($attributes);

        return Response::status('success')
            ->message('Deposit updated')
            ->result(new DepositResource($deposit));
    }
}
