<?php

namespace App\Http\Requests\MenuItem;

use App\Rules\Money;
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
            'price' => ['required', new Money()],
            'description' => ['required', 'string', 'max:299'],
        ];
    }
}
