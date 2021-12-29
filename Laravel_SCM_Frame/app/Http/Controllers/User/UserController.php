<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserPasswordChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * This is User Controller.
 * This will handle user CRUD processing.
 */
class UserController extends Controller
{
  /**
   * user interface
   */
  private $userInterface;
  /**
   * Create a new controller instance.
   * @param UserServiceInterface $userServiceInterface
   * @return void
   */
  public function __construct(UserServiceInterface $userServiceInterface)
  {
    $this->middleware('auth');
    $this->userInterface = $userServiceInterface;
  }

  /**
   * Show user profile
   *
   * @return View UserProfile
   */
  public function showUserProfile()
  {
    $userId = Auth::user()->id;
    $user = $this->userInterface->getUserById($userId);
    return view('users.profile', compact('user'));
  }

  /**
   * Show user profile edit
   * 
   * @return View User profile edit
   */
  public function showUserProfileEdit()
  {
    $userId = Auth::user()->id;
    $user = $this->userInterface->getUserById($userId);
    return view('users.profile-edit', compact('user'));
  }

  /**
   * To check profile edit form is valid or not.
   * If valid will return to profile edit confim page.
   * If not, redirect to profile edit page.
   * 
   * @param UserEditRequest $request request from profile edit
   * @return View profile edit confirm
   */
  public function submitEditProfileView(UserEditRequest $request)
  {
    // validation for request values
    $validated = $request->validated();
    $profile = $this->userInterface->storeProfileUnderTemp($validated);
    return redirect()
      ->route('profile.edit.confirm')
      ->withInput()
      ->with('profileName', $profile['name'])
      ->with('profilePath', $profile['path']);
  }

  /**
   * To show profile edit confirm view
   *
   * @return View profile edit confirm view
   */
  public function showEditProfileConfirmView()
  {
    if (old()) {
      return view('users.profile-edit-confirm');
    }
    return redirect()->route('profile');
  }

  /**
   * To submit profile edit confirmation view
   * @param Request $request request from profile edit confirm
   * @return View home
   */
  public function submitProfileEditConfirmView(Request $request)
  {
    $user = $this->userInterface->updateUser($request);
    return redirect()->route('profile');
  }

  /**
   * To show user list
   *
   * @return View User list
   */
  public function showUserList()
  {
    $userList = $this->userInterface->getUserList();
    return view('users.list', compact('userList'));
  }

  /**
   * To Show the application dashboard.
   *
   * @return View change password view
   */
  public function showChangePasswordView()
  {
    return view('users.change-password');
  }

  /**
   * To Show the application dashboard.
   * @param UserPasswordChangeRequest $request request for password change
   * @return View user profile
   */
  public function savePassword(UserPasswordChangeRequest $request)
  {
    // validation for request values
    $validated = $request->validated();
    $user = $this->userInterface->changeUserPassword($validated);
    return redirect()->route('profile');
  }

  /**
   * To delete user by id
   * @param string $userid user id
   * @return View user list
   */
  public function deleteUserById($userId)
  {
    $deletedUserId = Auth::user()->id;
    $msg = $this->userInterface->deleteUserById($userId, $deletedUserId);
    return response($msg, 204);
  }
}
