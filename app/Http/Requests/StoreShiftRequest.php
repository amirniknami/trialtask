<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShiftRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'shifts' => ['array','required_without:file'],
             'file'   => ['file','mimetypes:application/json,text/plain']
        ];
    }
}
