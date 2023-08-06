<?php

namespace Dkp\Seat\SeatDKP\Validation;

use Illuminate\Foundation\Http\FormRequest;

class addtooldkp extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required',
            'score' => 'required|regex:[^[0-9]+\.?[0-9]*$]',
            'remark' => 'string',
        ];
    }

}
