<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

/**
 * This is to check that password matches with old one.
 */
class MatchOldPassword implements Rule
{
  /**
   * Create a new rule instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Determine if the validation rule passes.
   * Pass if password match with old one.
   *
   * @param  string  $attribute
   * @param  mixed  $value
   * @return bool
   */
  public function passes($attribute, $value)
  {
    return Hash::check($value, auth()->user()->password);
  }

  /**
   * Get the validation error message.
   * 
   * @return string message
   */
  public function message()
  {
    return 'The :attribute is not match with old password.';
  }
}
