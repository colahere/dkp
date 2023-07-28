<?php

namespace Dkp\Seat\SeatDKP\Validation;

use Illuminate\Foundation\Http\FormRequest;

class addpap extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'trdkp' => 'required',
//            'score' => 'required|regex:[^[0-9]+\.?[0-9]*$]',
//            'skill_name' => 'string',
//            'skill_level' => 'regex:[^[0-9]+$]',
//            'ship_name' => 'string',
//            'station_name' => 'string',
//            'ship_num' => 'regex:[^[0-9]+$]',
        ];
    }

}
