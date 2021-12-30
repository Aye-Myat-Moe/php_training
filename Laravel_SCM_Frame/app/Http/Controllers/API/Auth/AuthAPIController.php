<?php

namespace App\Http\Controllers\API\Auth;

use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAPIRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * This is Authentication Controller for API.
 * This handles the login, logout processing of user.
 */
class AuthAPIController extends Controller
{
  /**
   * Auth Interface
   */
  private $authInterface;

  /**
   * Create a new controller instance.
   * @param AuthServiceInterface $authServiceInterface
   * @return void
   */
  public function __construct(AuthServiceInterface $authServiceInterface)
  {
    $this->authInterface = $authServiceInterface;
  }

  /**
   * This is to login for user.
   * @param LoginAPIRequest $request Request from user
   * @return Response json response
   */
  public function login(LoginAPIRequest $request)
  {
    // validation for request values
    $validated = $request->validated();
    $content = $this->authInterface->login($validated);
    return response()->json(
      $content['body'],
      $content['status']
    );
  }

  /**
   * This is to log out for user.
   * @return Response json response
   */
  public function logout()
  {
    Auth::guard('api')->user()->token()->revoke();
    return response()->json(
      ['message' => 'User logged out.'],
      JsonResponse::HTTP_OK
    );
  }
}
