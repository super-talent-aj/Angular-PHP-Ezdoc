<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SessionsRequest extends Request
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
        'email'    => 'required|email|min:2',
        'password' => 'required|min:6',
      ];
    }
}
