<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

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
    $this->middleware('auth');
    $this->authInterface = $authServiceInterface;
  }

  /**
   * To show registration view
   *
   * @return View registration form
   */
  protected function showRegistrationView()
  {
    return view('auth.register');
  }

  /**
   * To check register form is valid or not.
   * If valid will return to register confim page.
   * If not, redirect to register page.
   *
   * @param  UserRegisterRequest $request Request from register
   * @return View registration confirm
   */
  protected function submitRegistrationView(UserRegisterRequest $request)
  {
    // validation for request values
    $validated = $request->validated();
    $profile = $this->authInterface->storeProfileUnderTemp($validated);
    return redirect()
      ->route('register.confirm')
      ->withInput()
      ->with('profileName', $profile['name'])
      ->with('profilePath', $profile['path']);
  }

  /**
   * To show registration view
   *
   * @return View registration confirm view
   */
  protected function showRegistrationConfirmView()
  {
    if (old()) {
      return view('auth.register-confirm');
    }
    return redirect()
      ->route('userlist');
  }

  /**
   * To submit register confirm and save user info to DB
   *
   * @return View User list
   */
  protected function submitRegistrationConfirmView(Request $request)
  {
    $user = $this->authInterface->saveUser($request);
    return redirect()
      ->route('userlist');
  }
}
