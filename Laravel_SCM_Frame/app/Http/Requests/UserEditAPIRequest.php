<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;

class UserEditAPIRequest extends FormRequest
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
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::guard('api')->user()->id)],
      'profile' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
      'type' => [],
      'phone' => ['max:20'],
      'address' => ['max:255'],
      'dob' => [],
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
