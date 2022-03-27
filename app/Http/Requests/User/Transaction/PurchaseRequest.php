<?php

namespace App\Http\Requests\User\Transaction;

use App\Helpers\FormRequest;
use App\Rules\AvailableProduct;
use App\Rules\SufficientBalance;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_no' => 'required|string',
            'product_id' => ['required', 'numeric', 'exists:products,id', new AvailableProduct(), new SufficientBalance()],
        ];
    }
}
