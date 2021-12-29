<?php

namespace App\Contracts\Dao\Auth;

use Illuminate\Http\Request;

/**
 * Interface of Data Access Object for Authentication
 */
interface AuthDaoInterface
{
  /**
   * To Save User with values from request
   * @param Request $request request including inputs
   * @return Object created user object
   */
  public function saveUser(Request $request);
}
