<?php

namespace App\Http\Requests\Order;

use App\Rules\MobileNumber;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'quantity' => ['required', 'integer'],
            'location' => ['required', 'string', 'max:100'],
            'gps' => ['required', 'string', 'max:50'],
            'mobile_number' => ['required', 'max:20', new MobileNumber()],
        ];
    }
}
