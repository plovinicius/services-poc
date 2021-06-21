<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Validator;

abstract class BaseService
{
    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Validate all datas to execute the service.
     *
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        Validator::make($data, $this->rules())
            ->validate();

        return true;
    }
}
