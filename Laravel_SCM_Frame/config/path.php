<?php

return [
  /**
   * --------------------------------------------------------------------------
   * Path Separator
   * --------------------------------------------------------------------------
   * This value is the path reparator.
   */
  'separator' => env('SEPARATOR', '/'),

  /**
   * --------------------------------------------------------------------------
   * Public temp folder path
   * --------------------------------------------------------------------------
   * This value is the path for public temp folder.
   */
  'public_tmp' => env('PUBLIC_TMP', 'public/tmp/'),

  /**
   * --------------------------------------------------------------------------
   * Profile folder path
   * --------------------------------------------------------------------------
   * This value is the path for profile folder.
   */
  'profile' => env('PROFILE', 'profile/'),

  /**
   * --------------------------------------------------------------------------
   * Temp folder path
   * --------------------------------------------------------------------------
   * This value is the path for temp folder.
   */
  'tmp_path' => env('TMP_PATH', 'tmp/'),

  /**
   * --------------------------------------------------------------------------
   * App folder path under profile foloder
   * --------------------------------------------------------------------------
   * This value is the path for app folder under profile folder.
   */
  'profile_app_path' => env('PROFILE_APP_PATH', 'app/'),

  /**
   * --------------------------------------------------------------------------
   * CSV folder path
   * --------------------------------------------------------------------------
   * This value is the path for csv folder.
   */
  'csv' => env('CSV', 'csv/'),
];
