<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatisticsRequest extends FormRequest
{
    public function authorize()
    {
        // Access remains controlled by the existing statistics route middleware.
        return true;
    }

    protected function prepareForValidation()
    {
        foreach (['from', 'to'] as $field) {
            $value = $this->input($field);

            if (is_string($value) && preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $value, $parts))
                $this->merge([$field => $parts[3].'-'.$parts[2].'-'.$parts[1]]);
        }
    }

    public function rules()
    {
        return [
            'from' => 'nullable|date',
            'to' => 'nullable|date'.($this->filled('from') ? '|after_or_equal:from' : ''),
        ];
    }
}
