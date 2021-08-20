<?php

namespace App\Http\Requests;

use App\Rules\Iso8604DateTimeRule;
use Illuminate\Foundation\Http\FormRequest;

class ShiftIndexRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'location' => ['required', 'exists:locations,name'],
             'start'    => ['required', new Iso8604DateTimeRule()],
             'end'    => ['required', new Iso8604DateTimeRule()]
        ];
    }
}
