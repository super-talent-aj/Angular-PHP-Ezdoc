<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LawfirmsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        // since we're handling user authentication via middleware, we can simply switch this to return trueinstead
		    return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
      return [
        'name' => 'required',
        'country' => 'required',
        'state' => 'required',
        'province' => 'required',
        'city' => 'required',
        'street' => 'required',
        'zip_code' => 'required',
        'postal_code' => 'required',
      ];
    }
}
