<?php

namespace App\Dao\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Data Access Object for User
 */
class UserDao implements UserDaoInterface
{
  /**
   * To get user by id
   * @param string $id user id
   * @return Object $user user object
   */
  public function getUserById($id)
  {
    $user = User::find($id);
    return $user;
  }

  /**
   * To get user list
   * @return array $userList list of users
   */
  public function getUserList()
  {
    $userList = DB::table('users as user')
      ->join('users as created_user', 'user.created_user_id', '=', 'created_user.id')
      ->join('users as updated_user', 'user.updated_user_id', '=', 'updated_user.id')
      ->select('user.*', 'created_user.name as created_user', 'updated_user.name as updated_user')
      ->whereNull('user.deleted_at')
      ->get();
    return $userList;
  }

  /**
   * To Update User with values from request
   * @param Request $request request including inputs
   * @return Object updated user object
   */
  public function updateUser(Request $request)
  {
    $user = User::find(Auth::user()->id);
    $user->name = $request['name'];
    $user->email = $request['email'];
    $user->profile = $request['profile'];
    $user->type = $request['type'];
    $user->phone = $request['phone'];
    $user->dob = $request['dob'];
    $user->address = $request['address'];
    $user->updated_user_id = Auth::user()->id;
    $user->save();
    return $user;
  }

  /**
   * To change user password
   * @param array $validated Validated values from request
   * @return Object $user user object
   */
  public function changeUserPassword($validated)
  {
    $user = User::find(auth()->user()->id)
      ->update([
        'password' => Hash::make($validated['new_password']),
        'updated_user_id' => Auth::user()->id
      ]);
    return $user;
  }

  /**
   * To delete user by id
   * @param string $id user id
   * @param string $deletedUserId deleted user id
   * @return string $message message for success or not
   */
  public function deleteUserById($id, $deletedUserId)
  {
    $user = User::find($id);
    if ($user) {
      $user->deleted_user_id = $deletedUserId;
      $user->save();
      $user->delete();
      return 'Deleted Successfully!';
    }
    return 'User Not Found!';
  }

  /**
   * To save user that from api request
   * @param array $validated Validated values form request
   * @return Object created user object
   */
  public function saveUser($validated)
  {
    $profileName = time() . '.' . $validated['profile']->extension();
    $user = new User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->password = Hash::make($validated['password']);
    $user->profile = $profileName;
    $user->type = $validated['type'];
    $user->phone = $validated['phone'];
    $user->dob = $validated['dob'];
    $user->address = $validated['address'];
    $user->created_user_id = Auth::guard('api')->user()->id ?? 1;
    $user->updated_user_id = Auth::guard('api')->user()->id ?? 1;
    $user->save();
    return $user;
  }

  /**
   * To update user that from api request
   * @param array $validated Validated values form request
   * @return Object created user object
   */
  public function updateUserViaAPI($validated)
  {
    $user = User::find(Auth::guard('api')->user()->id);
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    if (array_key_exists("profile", $validated)) {
      $profileName = time() . '.' . $validated['profile']->extension();
      $user->profile = $profileName;
    }
    $user->type = $validated['type'];
    $user->phone = $validated['phone'];
    $user->dob = $validated['dob'];
    $user->address = $validated['address'];
    $user->updated_user_id = Auth::guard('api')->user()->id;
    $user->save();
    return $user;
  }

  /**
   * To change user password API
   * @param array $validated Validated values from request
   * @return Object $user user object
   */
  public function changeUserPasswordAPI($validated)
  {
    $user = User::find(Auth::guard('api')->user()->id)
      ->update([
        'password' => Hash::make($validated['new_password']),
        'updated_user_id' => Auth::guard('api')->user()->id
      ]);
    return $user;
  }
}
