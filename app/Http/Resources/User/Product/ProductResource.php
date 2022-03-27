<?php

namespace App\Http\Resources\User\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'sku_code' => $this->sku_code,
            'price' => $this->price + $this->margin,
            'status' => $this->status,
            'seller_status' => $this->seller_status,
            'unlimited_stock' => $this->unlimited_stock,
            'stock' => $this->stock,
            'multi' => $this->multi,
            'start_cut_off' => $this->start_cut_off,
            'end_cut_off' => $this->end_cut_off,
            'category' => new CategoryResource($this->category),
            'brand' => [
                'id' => $this->brand->id,
                'name' => $this->brand->name,
            ],
            'type' => [
                'id' => $this->type->id,
                'name' => $this->type->name,
            ],
        ];
    }
}
