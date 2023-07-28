<?php

namespace Dkp\Seat\SeatDKP\Validation;

use Illuminate\Foundation\Http\FormRequest;

class Commodity extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required',
        ];
    }

}