<?php

namespace App\Services\Auth;

use App\Contracts\Dao\Auth\AuthDaoInterface;
use App\Contracts\Services\Auth\AuthServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Service class for authentication.
 */
class AuthService implements AuthServiceInterface
{
  /**
   * auth Dao
   */
  private $authDao;

  /**
   * Class Constructor
   * @param AuthDaoInterface
   * @return
   */
  public function __construct(AuthDaoInterface $authDao)
  {
    $this->authDao = $authDao;
  }

  /**
   * To Save User with values from request
   * @param Request $request request including inputs
   * @return Object created user object
   */
  public function saveUser(Request $request)
  {
    $user = $this->authDao->saveUser($request);
    Storage::move(
      config('path.public_tmp') . $request['profile'],
      config('path.profile') . $user->id . config('path.separator') . $request['profile']
    );
    return $user;
  }

  /**
   * To store profile picture under temp folder.
   * @param  array $validated Validated from request
   * @return array profile name and profile path
   */
  public function storeProfileUnderTemp($validated)
  {
    $profileName = time() . '.' . $validated['profile']->extension();
    Storage::putFileAs(config('path.public_tmp'), $validated['profile'], $profileName);
    $profilePath = Storage::url(config('path.tmp_path') . $profileName);
    $profile = array('name' => $profileName, 'path' => $profilePath);
    return $profile;
  }

  /**
   * To login with validated user.
   * @param array $validated Validated fields from request
   * @return array response body and status
   */
  public function login($validated)
  {
    if (Auth::attempt($validated)) {
      $user = Auth::guard()->user();
      $tokenResult = $user->createToken('Personal Access Token');
      $token = $tokenResult->token;
      $token->save();
      return [
        'body' => ['data' => [
          'access_token' => $tokenResult->accessToken,
          'token_type' => 'Bearer',
          'expires_at' => Carbon::parse(
            $tokenResult->token->expires_at
          )->toDateTimeString(),
          'user_type' => $user['type'],
          'user_id' => $user['id'],
          'user_name' => $user['name'],
        ]],
        'status' => JsonResponse::HTTP_OK,
      ];
    }
    $message = "Email or password is incorrect.";
    return [
      'body' => ['errors' => ['message' => $message]],
      'status' => JsonResponse::HTTP_BAD_REQUEST,
    ];
  }
}
