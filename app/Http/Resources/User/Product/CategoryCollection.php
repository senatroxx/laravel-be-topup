<?php

namespace App\Http\Resources\User\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'current_page' => 1,
            'total_page' => 1,
            'total_records' => count($this->collection),
            'records' => $this->collection->transform(function ($item) {
                return new CategoryResource($item);
            }),
        ];
    }
}
