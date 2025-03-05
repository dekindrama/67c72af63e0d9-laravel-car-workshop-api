<?php

namespace App\Http\Requests\Admin\Repair;

use App\Enums\RepairStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RepairStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner_id' => ['required', 'integer', 'exists:users,id'],
            'car_number_plate' => ['required', 'string', 'max:255'],
            'car_description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', Rule::in(RepairStatusEnum::get())],
        ];
    }
}
