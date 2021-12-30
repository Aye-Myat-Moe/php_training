<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
  use SoftDeletes;
  use Notifiable, HasApiTokens;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id', 'name', 'email', 'password', 'profile', 'type', 'phone', 'dob', 'address', 'created_user_id', 'updated_user_id',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
  ];

  public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }
}
