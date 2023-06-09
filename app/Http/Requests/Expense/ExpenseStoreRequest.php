<?php

namespace App\Http\Requests\Expense;

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class ExpenseStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    try {
                        $date = Carbon::parse($value);
                    } catch (InvalidFormatException $e) {
                        $fail('The '.$attribute.' invalid date format.');
                    }

                    if ($date->greaterThan(Carbon::today()->endOfDay())) {
                        $fail('The '.$attribute.' cannot be in the future.');
                    }
                },
            ],
            'value' => 'required|numeric|min:0.01',
        ];
    }
}
