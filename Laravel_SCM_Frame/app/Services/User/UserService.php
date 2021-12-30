<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * User Service class
 */
class UserService implements UserServiceInterface
{
  /**
   * user Dao
   */
  private $userDao;

  /**
   * Class Constructor
   * @param UserDaoInterface
   * @return
   */
  public function __construct(UserDaoInterface $userDao)
  {
    $this->userDao = $userDao;
  }

  /**
   * To get user by id
   * @param string $id user id
   * @return Object $user user object
   */
  public function getUserById($id)
  {
    return $this->userDao->getUserById($id);
  }

  /**
   * To get user list
   * @return array $userList list of users
   */
  public function getUserList()
  {
    return $this->userDao->getUserList();
  }

  /**
   * To Update User with values from request
   * @param Request $request request including inputs
   * @return Object updated user object
   */
  public function updateUser(Request $request)
  {
    $user = $this->userDao->updateUser($request);
    if ($request['profile']) {
      Storage::move(
        config('path.public_tmp') . $request['profile'],
        config('path.profile') . Auth::user()->id . config('path.separator') . $request['profile']
      );
    }
    return $user;
  }

  /**
   * To change user password
   * @param array $validated Validated values from request
   * @return Object $user user object
   */
  public function changeUserPassword($validated)
  {
    return $this->userDao->changeUserPassword($validated);
  }

  /**
   * To delete user by id
   * @param string $id user id
   * @param string $deletedUserId deleted user id
   * @return string $message message for success or not
   */
  public function deleteUserById($id, $deletedUserId)
  {
    return $this->userDao->deleteUserById($id, $deletedUserId);
  }

  /**
   * To store profile picture under temp folder.
   * @param  array $validated Validated from request
   * @return array profile name and profile path
   */
  public function storeProfileUnderTemp($validated)
  {
    // set old profile name and path
    $profileName = Auth::user()->profile;
    $profilePath = config('path.separator') .
      config('path.profile') . Auth::user()->id .
      config('path.separator') . Auth::user()->profile;

    // store and set new profile path if profile included in request
    if (array_key_exists('profile', $validated)) {
      $profileName = time() . '.' . $validated['profile']->extension();
      Storage::putFileAs(config('path.public_tmp'), $validated['profile'], $profileName);
      $profilePath = Storage::url(config('path.tmp_path') . $profileName);
    }

    $profile = array('name' => $profileName, 'path' => $profilePath);
    return $profile;
  }

  /**
   * To save user that from api request
   * @param array $validated Validated values form request
   * @return Object created user object
   */
  public function saveUser($validated)
  {
    $user = $this->userDao->saveUser($validated);
    Storage::putFileAs(
      config('path.profile') . $user->id,
      $validated['profile'],
      $user->profile
    );
    return $user;
  }

  /**
   * To update user that from api request
   * @param array $validated Validated values form request
   * @return Object created user object
   */
  public function updateUserViaAPI($validated)
  {
    $user = $this->userDao->updateUserViaAPI($validated);
    if (array_key_exists("profile", $validated)) {
      Storage::putFileAs(
        config('path.profile') . $user->id,
        $validated['profile'],
        $user->profile
      );
    }
    return $user;
  }

  /**
   * To change user password API
   * @param array $validated Validated values from request
   * @return Object $user user object
   */
  public function changeUserPasswordAPI($validated) {
    return $this->userDao->changeUserPasswordAPI($validated);
  }
}
