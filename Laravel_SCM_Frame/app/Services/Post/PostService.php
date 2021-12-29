<?php

namespace App\Services\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Contracts\Services\Post\PostServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Service class for post.
 */
class PostService implements PostServiceInterface
{
  /**
   * post dao
   */
  private $postDao;
  /**
   * Class Constructor
   * @param PostDaoInterface
   * @return
   */
  public function __construct(PostDaoInterface $postDao)
  {
    $this->postDao = $postDao;
  }

  /**
   * To save post
   * @param Request $request request with inputs
   * @return Object $post saved post
   */
  public function savePost(Request $request)
  {
    return $this->postDao->savePost($request);
  }

  /**
   * To get post list
   * @return array $postList Post list
   */
  public function getPostList()
  {
    return $this->postDao->getPostList();
  }

  /**
   * To delete post by id
   * @param string $id post id
   * @param string $deletedUserId deleted user id
   * @return string $message message success or not
   */
  public function deletePostById($id, $deletedUserId)
  {
    return $this->postDao->deletePostById($id, $deletedUserId);
  }

  /**
   * To get post by id
   * @param string $id post id
   * @return Object $post post object
   */
  public function getPostById($id)
  {
    return $this->postDao->getPostById($id);
  }

  /**
   * To update post by id
   * @param Request $request request with inputs
   * @param string $id Post id
   * @return Object $post Post Object
   */
  public function updatedPostById(Request $request, $id)
  {
    return $this->postDao->updatedPostById($request, $id);
  }

  /**
   * To upload csv file for post
   * @param array $validated Validated values
   * @param string $uploadedUserId uploaded user id
   * @return array $content Message and Status of CSV Uploaded or not
   */
  public function uploadPostCSV($validated, $uploadedUserId)
  {
    $fileName = $validated['csv_file']->getClientOriginalName();
    Storage::putFileAs(config('path.csv') . $uploadedUserId .
      config('path.separator'), $validated['csv_file'], $fileName);
    return $this->postDao->uploadPostCSV($validated, $uploadedUserId);
  }

  /**
   * To download post csv file
   * @return File Download CSV file
   */
  public function downloadPostCSV()
  {
    $postList = $this->postDao->getPostList();
    $filename = "post.csv";
    //write csv file
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('Title', 'Description', 'Posted User', 'Posted Date'));

    foreach ($postList as $row) {
      fputcsv($handle, array(
        $row->title, $row->description, $row->created_user,
        date('Y/m/d', strtotime($row->created_at))
      ));
    }

    fclose($handle);

    $headers = array(
      'Content-Type' => 'text/csv',
    );

    return response()
      ->download($filename, $filename, $headers)
      ->deleteFileAfterSend();
  }

  /**
   * To save post via API
   * @param array $validated Validated values from request
   * @return Object created post object
   */
  public function savePostAPI($validated)
  {
    return $this->postDao->savePostAPI($validated);
  }

  /**
   * To update post by id via api
   * @param array $validated Validated values from request
   * @param string $id Post id
   * @return Object $post Post Object
   */
  public function updatedPostByIdAPI($validated, $postId)
  {
    return $this->postDao->updatedPostByIdAPI($validated, $postId);
  }
}
