<?php

namespace App\Dao\Auth;

use App\Contracts\Dao\Auth\AuthDaoInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Data Access Object for Authentication
 */
class AuthDao implements AuthDaoInterface
{
  /**
   * To Save User with values from request
   * @param Request $request request including inputs
   * @return Object created user object
   */
  public function saveUser(Request $request)
  {
    $user = new User();
    $user->name = $request['name'];
    $user->email = $request['email'];
    $user->password = Hash::make($request['password']);
    $user->profile = $request['profile'];
    $user->type = $request['type'];
    $user->phone = $request['phone'];
    $user->dob = $request['dob'];
    $user->address = $request['address'];
    $user->created_user_id = Auth::user()->id ?? 1;
    $user->updated_user_id = Auth::user()->id ?? 1;
    $user->save();
    return $user;
  }
}
