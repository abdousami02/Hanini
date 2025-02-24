<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;

class SendOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'qte' => 'required|integer|min:1|max:99',
            'name' => 'required|max:50|regex:/^[a-zA-Z\s]*$/',
            'mobile' => ['required','regex:/^(07|06|05)\d{8}$/'],
            'state' => 'required|integer|max:58',
            'address' => 'required|string',
            'location' => 'nullable'
        ];
    }
}
