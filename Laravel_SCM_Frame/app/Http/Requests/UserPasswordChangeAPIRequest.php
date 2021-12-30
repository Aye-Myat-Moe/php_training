<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPasswordAPI;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;

class UserPasswordChangeAPIRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
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
      'current_password' => ['required', new MatchOldPasswordAPI],
      'new_password' => ['required'],
      'new_confirm_password' => ['same:new_password'],
    ];
  }

  /**
   * This is to response JSON if fail validations.
   * @param Validator $validator
   * @return Response error json response
   */
  protected function failedValidation(Validator $validator)
  {
    $errors = $validator->errors();

    throw new HttpResponseException(
      response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
    );
  }
}
