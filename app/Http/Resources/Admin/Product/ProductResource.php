<?php

namespace App\Http\Resources\Admin\Product;

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
            'seller_name' => $this->seller_name,
            'sku_code' => $this->sku_code,
            'price' => $this->price,
            'margin' => $this->margin,
            'status' => $this->status,
            'seller_status' => $this->seller_status,
            'unlimited_stock' => $this->unlimited_stock,
            'stock' => $this->stock,
            'multi' => $this->multi,
            'start_cut_off' => $this->start_cut_off,
            'end_cut_off' => $this->end_cut_off,
            'category' => new CategoryResource($this->category),
            'brand' => new BrandResource($this->brand),
            'type' => new TypeResource($this->type),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
