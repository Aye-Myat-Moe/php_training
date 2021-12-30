<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * To get user profile image
   *
   * @return Image user profile if exist.
   */
  public function getUserProfile($userId, $profileName)
  {
    $path =  config('path.profile') . $userId . config('path.separator') . $profileName;
    if (!Storage::disk('local')->exists($path)) {
      abort(404);
    }

    return response()->file(storage_path(config('path.profile_app_path') . $path));
  }

  /**
   * To get user profile image via API
   *
   * @return string base64 profile.
   */
  public function getUserProfileViaAPI($userId, $profileName)
  {
    $path =  config('path.profile') . $userId . config('path.separator') . $profileName;
    if (!Storage::disk('local')->exists($path)) {
      abort(404);
    }

    return response()->json([base64_encode(file_get_contents(storage_path(config('path.profile_app_path') . $path)))]);
  }
}
