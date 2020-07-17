<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job\JobItems\JobItem;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\MovieUploadRequest;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\ShJobop\JobItems\Repositories\JobItemRepository;
use File;
use Storage;
use Auth;
use Image;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;

class MediaController extends Controller
{

  /**
   * @var JobItemRepositoryInterface
   */
  private $JobItemRepo;

  /**
   * JobItemController constructor.
   * 
   * @param JobItemRepositoryInterface $jobItemRepository
   */

   public function __construct(JobItemRepositoryInterface $jobItemRepository)
   {
     $this->JobItemRepo = $jobItemRepository;

     $this->middleware(['employer']);
   }


    /**
     * Display a main page of the uploading main image
     * 
     * @return \Illuminate\Http\Response
     */
    public function getMainImage($id='')
    {
      if($id != '') {
        $job = JobItem::findOrFail($id);

        return view('jobs.post.main_image', compact('job'));

      }

      $job = '';
      return view('jobs.post.main_image', compact('job'));
    }

    public function postImage(ImageUploadRequest $request, $id = '')
    {
      $disk = Storage::disk('s3');
      $imageFlag = $request->input('imageFlag');
  
      if($request->hasfile('data.File.image')) {

        // 新規作成画面かどうか
        if($id !== '') {

          $job = JobItem::findOrFail($id);
          $editFlag = 1;

          if(session()->has('data.file.edit_image') && is_array(session()->get('data.file.edit_image'))) {
      
             // もしセッションに画像がセットされている且つs3・ローカルにファイルが保存されていたら、削除
             $edit_image_path_list = $this->JobItemRepo->existJobItemImageAndDeleteOnPost($imageFlag, $editFlag);

          }
        } else {
          $job = '';
          if(session()->has('data.file.image') && is_array(session()->get('data.file.image'))) {
            // もしセッションに画像がセットされている且つs3・ローカルにファイルが保存されていたら、削除
            $image_path_list = $this->JobItemRepo->existJobItemImageAndDeleteOnPost($imageFlag);
          }
        }

        // サブ１かサブ２の判定フラグ
        $suffix = $request->input('data.File.suffix');

        // 画像ファイルをs3・ローカルに保存に保存
        $image_path = $this->JobItemRepo->saveJobItemImages($request->file('data.File.image'), $imageFlag);
        
        // 新規作成画面かどうか
        if($id != '') {
          
          $edit_image_path_list[$imageFlag] = $image_path;
          $request->session()->put('data.file.edit_image', $edit_image_path_list);
          $request->session()->put('data.jobId', $id);

        } else {

          $image_path_list[$imageFlag] = $image_path;
          $request->session()->put('data.file.image', $image_path_list);
        }

        // 登録完了画面を返す
        if($imageFlag == 'main') {
          return view('jobs.post.main_image_complete', compact('job'));
        } else {
          return view('jobs.post.sub_image_complete', compact('job', 'suffix'));
        }

      } else {

        if($movieFlag == 'main') {
          return redirect()->back()->with('message_danger', '登録するメイン画像が選ばれていません');
        } else {
          return redirect()->back()->with('message_danger', '登録するサブ画像が選ばれていません');
        }

      }

    }

    public function imageDelete(Request $request, $id='')
    {

      $disk = Storage::disk('s3');
      $imageFlag = $request->imageflag;

       // 新規作成画面かどうか
      if($id != '') {

        $job = JobItem::findOrFail($id);
        $editFlag = 1;

        if(session()->has('data.file.edit_image.'. $imageFlag) && is_array(session()->get('data.file.edit_image'))) {

          // もしセッションに画像がセットされている且つs3・ローカルにファイルが保存されていたら、削除
          $this->JobItemRepo->existJobItemImageAndDeleteOnDelete($imageFlag, $editFlag, $job);

           // 削除完了画面を返す
          if($imageFlag === 'main') {
            return redirect()->back()->with('message_success', 'メイン写真を削除しました');
          } else {
            return redirect()->back()->with('message_success', 'サブ写真を削除しました');
          }

        } else {

          switch($imageFlag) {
            case $imageFlag === 'main':
                $jobImagePath = $job->job_img;
                break;
            case $imageFlag === 'sub1':
                $jobImagePath = $job->job_img2;
                break;
            case $imageFlag === 'sub2':
                $jobImagePath = $job->job_img3;
                break;
            default:
                $jobImagePath = null;
          }

          if($jobImagePath !== null) {
            session()->put('data.file.edit_image.' . $imageFlag, '');
            session()->put('data.jobId', $id);

             // 削除完了画面を返す
            if($imageFlag == 'main') {
              return redirect()->back()->with('message_success', 'メイン写真を削除しました');
            } else {
              return redirect()->back()->with('message_success', 'サブ写真を削除しました');
            }
          }

          // 画像がセットされていないならエラー画面を返す
          if($imageFlag == 'main') {
            return redirect()->back()->with('message_danger', '削除するメイン写真はありません');
          } else {
            return redirect()->back()->with('message_danger', '削除する　サブ写真はありません');
          }

        }


      } else {
        // 新規作成時

        if (session()->has('data.file.image.'.$imageFlag) && is_array(session()->get('data.file.image'))) {

          // もしセッションに画像がセットされている且つs3・ローカルにファイルが保存されていたら、削除
          $this->JobItemRepo->existJobItemImageAndDeleteOnDelete($imageFlag);

          if($imageFlag == 'main') {
            return redirect()->back()->with('message_success', 'メイン写真を削除しました');
          } else {
            return redirect()->back()->with('message_success', 'サブ写真を削除しました');
          }

         

        } else {

          if($imageFlag == 'main') {
            return redirect()->back()->with('message_danger', '削除するメイン写真はありません');
          } else {
            return redirect()->back()->with('message_danger', '削除するサブ写真はありません');
          }

        }

      }

    }

    //sub image
    public function getSubImage1($id='')
    {
      if($id) {
        $job = JobItem::findOrFail($id);
        return view('jobs.post.sub_image_01', compact('job'));
      }

      $job = '';
      return view('jobs.post.sub_image_01', compact('job'));

    }

    public function getSubImage2($id='')
    {
      if($id) {
        $job = JobItem::findOrFail($id);
        return view('jobs.post.sub_image_02', compact('job'));
      }

      $job = '';
      return view('jobs.post.sub_image_02', compact('job'));

    }

    //main movie
    public function getMainMovie($id='')
    {
      if($id) {
        $job = JobItem::findOrFail($id);
        return view('jobs.post.main_movie', compact('job'));
      }
      $job = '';
      return view('jobs.post.main_movie', compact('job'));
    }

    public function postMovie(MovieUploadRequest $request, $id='')
    {

      $disk = Storage::disk('s3');
      $movieFlag = $request->input('movieFlag');

      if($request->hasfile('data.File.movie')) {
        // 新規作成画面かどうか  
        if($id != '') {
          // 編集時
          $job = JobItem::findOrFail($id);
          $editFlag = 1;

          if(session()->has('data.file.edit_movie') && is_array(session()->get('data.file.edit_movie'))) {
              // もしセッションに動画がセットされている且つs3・ローカルにファイルが保存されていたら、削除
              $edit_movie_path_list = $this->JobItemRepo->existJobItemMovieAndDeleteOnPost($movieFlag, $editFlag);
          }

        } else {
          // 新規作成時
          $job = '';
          if(session()->has('data.file.movie') && is_array(session()->get('data.file.movie'))) {
            // もしセッションに動画がセットされている且つs3・ローカルにファイルが保存されていたら、削除
            $movie_path_list = $this->JobItemRepo->existJobItemMovieAndDeleteOnPost($movieFlag);
          }
        }

        // サブ１かサブ２の判定フラグ
        $suffix = $request->input('data.File.suffix');
        // 動画ファイルをs3・ローカルに保存に保存
        $movie_path = $this->JobItemRepo->saveJobItemMovies($request->file('data.File.movie'), $movieFlag);

        // $after_movie = shell_exec('ffmpeg -i ' . '/public' . \Config::get('fpath.tmp_mov') . $main_movie_name .  '-vf scale=320:-1' . '/public' . \Config::get('fpath.tmp_mov') . 'sample.mp4' . 'pipe:1');
        // $beforeMovie = FFMpeg::fromDisk('local')->open(\Config::get('fpath.tmp_mov'), $main_movie_name);
        // $beforeMovieStreams = $beforeMovie->getStreams()->first();
        // $beforeMovie->addFilter(function ($filters) {
        //     $filters->resize(new \FFMpeg\Coordinate\Dimension(720, 480));
        // })
        // ->export()
        // ->toDisk('public')
        // ->inFormat(new \FFMpeg\Format\Video\X264('aac'))
        // ->save(\Config::get('fpath.tmp_mov'), $main_movie_name);

        if($id !== '') {
          $edit_movie_path_list[$movieFlag] = $movie_path;
          $request->session()->put('data.file.edit_movie', $edit_movie_path_list);
          $request->session()->put('data.jobId', $id);

        } else {
          $movie_path_list[$movieFlag] = $movie_path;
          $request->session()->put('data.file.movie', $movie_path_list);
        }


        // 登録完了画面を返す
        if($movieFlag === 'main') {
          return view('jobs.post.main_movie_complete', compact('job'));
        } else {
          return view('jobs.post.sub_movie_complete', compact('job', 'suffix'));
        }

      } else {

        if($movieFlag === 'main') {
          return redirect()->back()->with('message_danger', '登録するメイン動画が選ばれていません');
        } else {
          return redirect()->back()->with('message_danger', '登録するサブ動画が選ばれていません');
        }
      }
    }

    public function movieDelete(Request $request, $id = '')
    {
      $disk = Storage::disk('s3');
      $movieFlag = $request->movieflag;
      // 新規作成画面かどうか
      if($id !== '') {
        // 編集時
        $job = JobItem::findOrFail($id);
        $editFlag = 1;

        if(session()->has('data.file.edit_movie.' . $movieFlag) && is_array(session()->get('data.file.edit_movie'))) {
          // もしセッションに画像がセットされている且つs3・ローカルにファイルが保存されていたら、削除
          $this->JobItemRepo->existJobItemMovieAndDeleteOnDelete($movieFlag, $editFlag, $job);
          
          if($movieFlag === 'main') {
            return redirect()->back()->with('message_success', 'メイン動画を削除しました');
          } else {
            return redirect()->back()->with('message_success', 'サブ動画を削除しました');
          }

        } else {
          switch($movieFlag) {
            case $movieFlag === 'main':
                $jobMoviePath = $job->job_mov;
                break;
            case $movieFlag === 'sub1':
                $jobMoviePath = $job->job_mov2;
                break;
            case $movieFlag === 'sub2':
                $jobMoviePath = $job->job_mov3;
                break;
            default:
                $jobMoviePath = null;
          }

          if($jobMoviePath !== null) {
            session()->put('data.file.edit_movie.' . $movieFlag, '');
            session()->put('data.jobId', $id);

            // 削除完了画面を返す
            if($movieFlag === 'main') {
              return redirect()->back()->with('message_success', 'メイン動画を削除しました');
            } else {
              return redirect()->back()->with('message_success', 'サブ動画を削除しました');
            }

          }

          // 動画がセットされていないならエラー画面を返す
          if($movieFlag === 'main') {
            return redirect()->back()->with('message_danger', '削除するメイン動画はありません');
          } else {
            return redirect()->back()->with('message_danger', '削除する　サブ動画はありません');
          }
        }

      } else {
        // 新規作成時
        if (session()->has('data.file.movie.'.$movieFlag) && is_array(session()->get('data.file.movie'))) {
           // もしセッションに動画がセットされている且つs3・ローカルにファイルが保存されていたら、削除
           $this->JobItemRepo->existJobItemMovieAndDeleteOnDelete($movieFlag);

          if($movieFlag === 'main') {
            return redirect()->back()->with('message_success', 'メイン動画を削除しました');
          } else {
            return redirect()->back()->with('message_success', 'サブ動画を削除しました');
          }

        } else {
          if($movieFlag === 'main') {
            return redirect()->back()->with('message_danger', '削除するメイン動画はありません');
          } else {
            return redirect()->back()->with('message_danger', '削除するサブ動画はありません');
          }
        }
      }
    }

    //sub movie
    public function getSubMovie1($id='')
    {
      if($id) {
        $job = JobItem::findOrFail($id);
        return view('jobs.post.sub_movie_01', compact('job'));
      }
      $job = '';
      return view('jobs.post.sub_movie_01', compact('job'));
    }

    public function getSubMovie2($id='')
    {
      if($id) {
        $job = JobItem::findOrFail($id);
        return view('jobs.post.sub_movie_02', compact('job'));
      }
      $job = '';
      return view('jobs.post.sub_movie_02', compact('job'));
    }
    
}
