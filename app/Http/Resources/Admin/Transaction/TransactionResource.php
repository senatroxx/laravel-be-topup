<?php

namespace App\Http\Resources\Admin\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ref_id' => $this->ref_id,
            'product' => $this->product,
            'customer_no' => $this->customer_no,
            'sku_code' => $this->sku_code,
            'serial_number' => $this->serial_number,
            'status' => $this->status,
            'amount' => $this->amount,
            'response_code' => $this->response_code,
            'balance_history' => [
                'id' => $this->balanceHistory->id,
                'amount' => $this->balanceHistory->amount,
                'type' => $this->balanceHistory->type,
                'balance_id' => $this->balanceHistory->balance_id,
                'created_at' => $this->balanceHistory->created_at,
                'updated_at' => $this->balanceHistory->updated_at,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
