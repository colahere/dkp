<?php

namespace Dkp\Seat\SeatDKP\Validation;

use Illuminate\Foundation\Http\FormRequest;

class AddSupplement extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'supplement_name' => 'required',
            'supplement_num' => 'required|regex:[^[0-9]+\.?[0-9]*$]',
            'use_dkp' => 'required|regex:[^[0-9]+\.?[0-9]*$]',
            'all_dkp' => 'required|regex:[^[0-9]+\.?[0-9]*$]',
        ];
    }

}