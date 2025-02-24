<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'seller_id' => 'required|integer|exists:seller_profiles,id',
            'name'      => 'required|string|max:80',
            'description'   => 'required',
            'image'         => 'nullable',
            'price'         => 'required|integer',
            'is_active'     => 'nullable|in:0,1',
            'per_day'       => 'nullable|integer'
        ];
    }
}
