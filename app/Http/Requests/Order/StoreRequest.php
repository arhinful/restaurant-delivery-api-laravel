<?php

namespace App\Http\Requests\Order;

use App\Rules\MobileNumber;
use App\Traits\RequestDefaultValuesTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    use RequestDefaultValuesTrait;
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
            'menu_item_id' => ['required', 'string'],
            'quantity' => ['required', 'integer'],
            'location' => ['required', 'string', 'max:100'],
            'gps' => ['required', 'string', 'max:50'],
            'mobile_number' => ['required', 'max:20', new MobileNumber()],

            // in case order creation is by admin and order is meant for normal user
            'custom_user_id' => ['nullable', 'exists:user,id'],
        ];
    }

    public function defaults(): array{
        return [
            // our default user_id if request is coming from normal user
            'user_id' => auth()->id()
        ];
    }
}

