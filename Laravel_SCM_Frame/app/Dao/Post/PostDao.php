<?php

namespace App\Dao\Post;

use App\Models\Post;
use App\Contracts\Dao\Post\PostDaoInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Data accessing object for post
 */
class PostDao implements PostDaoInterface
{
  /**
   * To save post
   * @param Request $request request with inputs
   * @return Object $post saved post
   */
  public function savePost(Request $request)
  {
    $post = new Post();
    $post->title = $request['title'];
    $post->description = $request['description'];
    $post->created_user_id = Auth::user()->id ?? 1;
    $post->updated_user_id = Auth::user()->id ?? 1;
    $post->save();
    return $post;
  }

  /**
   * To get post list
   * @return array $postList Post list
   */
  public function getPostList()
  {
    $postList = DB::table('posts as post')
      ->join('users as created_user', 'post.created_user_id', '=', 'created_user.id')
      ->join('users as updated_user', 'post.updated_user_id', '=', 'updated_user.id')
      ->select('post.*', 'created_user.name as created_user', 'updated_user.name as updated_user')
      ->whereNull('post.deleted_at')
      ->get();
    return $postList;
  }

  /**
   * To delete post by id
   * @param string $id post id
   * @param string $deletedUserId deleted user id
   * @return string $message message success or not
   */
  public function deletePostById($id, $deletedUserId)
  {
    $post = Post::find($id);
    if ($post) {
      $post->deleted_user_id = $deletedUserId;
      $post->save();
      $post->delete();
      return 'Deleted Successfully!';
    }
    return 'Post Not Found!';
  }

  /**
   * To get post by id
   * @param string $id post id
   * @return Object $post post object
   */
  public function getPostById($id)
  {
    $post = Post::find($id);
    return $post;
  }

  /**
   * To update post by id
   * @param Request $request request with inputs
   * @param string $id Post id
   * @return Object $post Post Object
   */
  public function updatedPostById(Request $request, $id)
  {
    $post = Post::find($id);
    $post->title = $request['title'];
    $post->description = $request['description'];
    if ($request['status']) {
      $post->status = '1';
    } else {
      $post->status = '0';
    }
    $post->updated_user_id = Auth::user()->id;
    $post->save();
    return $post;
  }

  /**
   * To upload csv file for post
   * @param array $validated Validated values
   * @param string $uploadedUserId uploaded user id
   * @return array $content Message and Status of CSV Uploaded or not
   */
  public function uploadPostCSV($validated, $uploadedUserId)
  {
    $path =  $validated['csv_file']->getRealPath();
    $csv_data = array_map('str_getcsv', file($path));
    // save post to Database accoding to csv row
    foreach ($csv_data as $index => $row) {
      if (count($row) >= 2) {
        try {
          $post = new Post();
          $post->title = $row[0];
          $post->description = $row[1];
          $post->created_user_id = $uploadedUserId ?? 1;
          $post->updated_user_id = $uploadedUserId ?? 1;
          $post->save();
        } catch (\Illuminate\Database\QueryException $e) {
          $errorCode = $e->errorInfo[1];
          //error handling for duplicated post
          if ($errorCode == '1062') {
            $content = array(
              'isUploaded' => false,
              'message' => 'Row number (' . ($index + 1) . ') is duplicated title.'
            );
            return $content;
          }
        }
      } else {
        // error handling for invalid row.
        $content = array(
          'isUploaded' => false,
          'message' => 'Row number (' . ($index + 1) . ') is invalid format.'
        );
        return $content;
      }
    }
    $content = array(
      'isUploaded' => true,
      'message' => 'Uploaded Successfully!'
    );
    return $content;
  }

  /**
   * To save post via API
   * @param array $validated Validated values from request
   * @return Object created post object
   */
  public function savePostAPI($validated)
  {
    $post = new Post();
    $post->title = $validated['title'];
    $post->description = $validated['description'];
    $post->created_user_id = Auth::guard('api')->user()->id ?? 1;
    $post->updated_user_id = Auth::guard('api')->user()->id ?? 1;
    $post->save();
    return $post;
  }

  /**
   * To update post by id via api
   * @param array $validated Validated values from request
   * @param string $postId Post id
   * @return Object $post Post Object
   */
  public function updatedPostByIdAPI($validated, $postId)
  {
    $post = Post::find($postId);
    $post->title = $validated['title'];
    $post->description = $validated['description'];
    $post->status = $validated["status"];
    $post->updated_user_id = Auth::guard('api')->user()->id;
    $post->save();
    return $post;
  }
}
