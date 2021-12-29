<?php

namespace App\Contracts\Services\Auth;

use Illuminate\Http\Request;

/**
 * Interface for authentication service.
 */
interface AuthServiceInterface
{
  /**
   * To Save User with values from request
   * @param Request $request request including inputs
   * @return Object created user object
   */
  public function saveUser(Request $request);

  /**
   * To store profile picture under temp folder.
   * @param  array $validated Validated from request
   * @return array profile name and profile path
   */
  public function storeProfileUnderTemp($validated);

   /**
   * To login with validated user.
   * @param array $validated Validated fields from request
   * @return array response content and status
   */
  public function login($validated);
}
