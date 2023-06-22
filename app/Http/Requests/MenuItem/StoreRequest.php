<?php

namespace App\Http\Requests\MenuItem;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'restaurant_id' => ['required', 'string', 'exists:restaurants,id'],
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'string', 'max:199'],
            'description' => ['required', 'string', 'max:299'],
        ];
    }
}
