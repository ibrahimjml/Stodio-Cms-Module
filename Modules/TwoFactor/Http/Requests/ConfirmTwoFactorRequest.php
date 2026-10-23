<?php

namespace Modules\TwoFactor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmTwoFactorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'code' => ['nullable', 'required_without:recovery_code', 'numeric', 'digits:6'],
            'recovery_code' => ['nullable', 'required_without:code', 'string'],
        ];
    }

    public function code()
    {
        return $this->input('code');
    }

    public function recovery()
    {
        return $this->input('recovery_code');
    }
}
