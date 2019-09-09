<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;

abstract class Request extends FormRequest
{
    //
  /**
   * {@inheritdoc}
   */

  public function response(array $errors)
  {
    if (($this->ajax() && ! $this->pjax()) || $this->wantsJson()) {
      return new JsonResponse([
        'code' => 422,
        'errors' => $errors
      ], 422);
    }

    return $this->redirector->to($this->getRedirectUrl())
      ->withInput($this->except($this->dontFlash))
      ->withErrors($errors, $this->errorBag);
  }
}
