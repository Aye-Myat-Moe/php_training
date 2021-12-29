<?php

namespace App\Http\Controllers\API\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditAPIRequest;
use App\Http\Requests\UserPasswordChangeAPIRequest;
use App\Http\Requests\UserRegisterAPIRequest;
use Illuminate\Support\Facades\Auth;

class UserAPIController extends Controller
{
  /**
   * User Interface
   */
  private $userInterface;

  /**
   * Create a new controller instance.
   * @param UserServiceInterface $userServiceInterface
   * @return void
   */
  public function __construct(UserServiceInterface $userServiceInterface)
  {
    $this->userInterface = $userServiceInterface;
  }

  /**
   * This is to create user that request via api.
   * @param UserRegisterAPIRequest $request Request via api
   * @return Response json response
   */
  public function createUser(UserRegisterAPIRequest $request)
  {
    // validation for request values
    $validated = $request->validated();
    $user = $this->userInterface->saveUser($validated);
    return response()->json($user);
  }

  public function updateUser(UserEditAPIRequest $request)
  {
    // validation for request values
    $validated = $request->validated();
    $user = $this->userInterface->updateUserViaAPI($validated);
    return response()->json($user);
  }

  /**
   * This is to get user list.
   * @return Repsonse json response with user list
   */
  public function getUserList()
  {
    $userList = $this->userInterface->getUserList();
    return response()->json($userList);
  }

  /**
   * To delete user by id via api
   * @param string $userid user id
   * @return Response message
   */
  public function deleteUserById($userId)
  {
    $deletedUserId = Auth::guard('api')->user()->id;
    $msg = $this->userInterface->deleteUserById($userId, $deletedUserId);
    return response(['message' => $msg]);
  }

  /**
   * To get current login user profile.
   * @return Response json user info
   */
  public function getUserProfile()
  {
    $userId = Auth::guard('api')->user()->id;
    $user = $this->userInterface->getUserById($userId);
    return response()->json($user);
  }

  /**
   * To Show the application dashboard.
   * @param UserPasswordChangeRequest $request request for password change
   * @return View user profile
   */
public function savePassword(UserPasswordChangeAPIRequest $request)
  {
    // validation for request values
    $validated = $request->validated();
    $user = $this->userInterface->changeUserPasswordAPI($validated);
    return response()->json($user);
  }
  
}
