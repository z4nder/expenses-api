<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'value' =>(float) $this->value,
            'formatted_value' => 'R$ '.str_replace(",",".", (float) $this->value),
            'date' => $this->date->format('d/m/Y'),
        ];
    }
}
