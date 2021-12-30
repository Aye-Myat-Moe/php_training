<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserTest extends TestCase
{
  use RefreshDatabase;

  /**
   * This is to setup initial functions before starting test cases.
   * @return void
   */
  public function setup(): void
  {
    parent::setUp();
    $this->loginWithFakeAdmin();
  }

  /**
   * This is to tear down functions after running test cases.
   * @return void
   */
  public function tearDown(): void {
    parent::tearDown();
  }

  /**
   * This is to login with admin.
   * @return void
   */
  public function loginWithFakeAdmin()
  {
    $user = new User([
      'id' => 1,
      'name' => 'yish',
      'type' => 0,
    ]);

    $this->be($user);
  }

  /**
   * This is to test login authentication.
   * 
   * Expectation is to redirect home after login.
   * @return void
   */
  public function testLoginAuthentication()
  {
    $user = factory(User::class)->create();
    $response = $this->post(route('login'), [
      'email' => $user->email,
      'password' => 'password'
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticatedAs($user);
  }

  /**
   * This is to test user registration.
   * 
   * Expectation is to redirect to registration confirm.
   * @return void
   */
  public function testUserRegister()
  {
    $response = $this->post('/user/register', [
      'name' => 'test_user',
      'email' => 'test_user@gmail.com',
      'password' => 'password',
      'password_confirmation' => 'password',
      'profile' => UploadedFile::fake()->image('profile.jpg'),
      'type' => 1
    ]);
    Storage::deleteDirectory(config('path.public_tmp'));
    $response->assertRedirect(route('register.confirm'));
  }
}
