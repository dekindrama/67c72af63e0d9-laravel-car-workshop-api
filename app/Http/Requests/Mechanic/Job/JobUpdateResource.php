<?php

namespace App\Http\Requests\Mechanic\Job;

use App\Enums\RepairJobStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobUpdateResource extends FormRequest
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
            'status' => ['required', 'string', Rule::in([
                RepairJobStatusEnum::PROGRESS,
                RepairJobStatusEnum::COMPLETED,
            ])],
        ];
    }
}
