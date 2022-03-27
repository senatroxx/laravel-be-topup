<?php

namespace App\Http\Resources\User\Invoice;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'invoice_id' => $this->invoice_id,
            'invoice_url' => $this->invoice_url,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'amount' => $this->amount,
            'balance_history' => [
                'id' => $this->balanceHistory->id,
                'amount' => $this->balanceHistory->amount,
                'type' => $this->balanceHistory->type,
            ],
            'paid_at' => $this->paid_at,
            'expiry_date' => $this->expiry_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
