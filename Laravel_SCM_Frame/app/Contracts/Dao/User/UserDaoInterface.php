<?php

namespace App\Contracts\Dao\User;

use Illuminate\Http\Request;

/**
 * Interface of Data Access Object for user
 */
interface UserDaoInterface
{
  /**
   * To get user by id
   * @param string $id user id
   * @return Object $user user object
   */
  public function getUserById($id);

  /**
   * To get user list
   * @return array $userList list of users
   */
  public function getUserList();

  /**
   * To Update User with values from request
   * @param Request $request request including inputs
   * @return Object updated user object
   */
  public function updateUser(Request $request);

  /**
   * To change user password
   * @param array $validated Validated values from request
   * @return Object $user user object
   */
  public function changeUserPassword($validated);

  /**
   * To delete user by id
   * @param string $id user id
   * @param string $deletedUserId deleted user id
   * @return string $message message for success or not
   */
  public function deleteUserById($id, $deletedUserId);

  /**
   * To save user that from api request
   * @param array $validated Validated values form request
   * @return Object created user object
   */
  public function saveUser($validated);

  /**
   * To update user that from api request
   * @param array $validated Validated values form request
   * @return Object created user object
   */
  public function updateUserViaAPI($validated);

  /**
   * To change user password API
   * @param array $validated Validated values from request
   * @return Object $user user object
   */
  public function changeUserPasswordAPI($validated);
}
