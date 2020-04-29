<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job\JobItems\JobItem;
use App\Http\Requests\MainImageUploadRequest;
use App\Http\Requests\SubImageUploadRequest;
use App\Http\Requests\MainMovieUploadRequest;
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

    public function postMainImage(MainImageUploadRequest $request, $id='')
    {
  
      if($request->hasfile('data.File.image')) {

        $disk = Storage::disk('s3');
        $imageFlag = $request->input('imageFlag');


        if($id != '') {
          //edit
          $job = JobItem::findOrFail($id);

          if(session()->has('data.file.edit_image') && is_array(session()->get('data.file.edit_image'))) {
            $edit_image_path_list = session()->get('data.file.edit_image');
            if(isset($edit_image_path_list['main'])) {
              if (File::exists(public_path() . $edit_image_path_list['main']) && $job->job_img != $edit_image_path_list['main']) {
                File::delete(public_path() . $edit_image_path_list['main']);
              }

              unset($edit_image_path_list['main']);
            }

          }

        } else {
          // 新規作成時

          $job = '';

          if(session()->has('data.file.image') && is_array(session()->get('data.file.image'))) {

            // もしセッションに画像がセットされている且つs3・ローカルにファイルが保存されていたら、削除
            $image_path_list = $this->JobItemRepo->existJobItemImageAndDeleteOnPost($imageFlag);
            
          }
        }

        // 画像ファイルをs3・ローカルに保存に保存
        $image_path = $this->JobItemRepo->saveJobItemImages($request->file('data.File.image'), $imageFlag);
        
        if($id != '') {
          
          $edit_image_path_list['main'] = $image_path;
          $request->session()->put('data.file.edit_image', $edit_image_path_list);

          return view('jobs.post.main_image_complete', compact('job'));

        } else {

          $image_path_list['main'] = $image_path;
          $request->session()->put('data.file.image', $image_path_list);
        }

        return view('jobs.post.main_image_complete', compact('job'));

      } else {

        return view('jobs.post.main_image');

      }

    }

    public function mainImageDelete(Request $request, $id='')
    {

      $disk = Storage::disk('s3');
      $imageFlag = $request->imageflag;

      if($id != '') {
        // edit
        $job = JobItem::findOrFail($id);

        if(session()->has('data.file.edit_image.main') && is_array(session()->get('data.file.edit_image'))) {

          $edit_image_path_list = session()->get('data.file.edit_image');

          if (File::exists(public_path() . $edit_image_path_list['main']) && $job->job_img != $edit_image_path_list['main']) {
              File::delete(public_path() . $edit_image_path_list['main']);
          }

          

          if($job->job_img != null) {
            $edit_image_path_list['main'] = '';
          } else {
            unset($edit_image_path_list['main']);
          }

          session()->put('data.file.edit_image', $edit_image_path_list);

          return redirect()->back()->with('message_success', 'メイン写真を削除しました');

        } else {

          if($job->job_img != null) {
            session()->put('data.file.edit_image.main', '');
            return redirect()->back()->with('message_success', 'メイン写真を削除しました');
          }

          return redirect()->back()->with('message_danger', '削除するメイン写真はありません');
        }


      } else {
        // 新規作成時

        if (session()->has('data.file.image.main') && is_array(session()->get('data.file.image'))) {

          // もしセッションに画像がセットされている且つs3・ローカルにファイルが保存されていたら、削除
          $this->JobItemRepo->existJobItemImageAndDeleteOnDelete($imageFlag);

          return redirect()->back()->with('message_success', 'メイン写真を削除しました');

        } else {

          return redirect()->back()->with('message_danger', '削除するメイン写真はありません');

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

    public function postSubImage1(SubImageUploadRequest $request, $id='')
    {

      if($request->hasfile('data.File.image')) {

        $disk = Storage::disk('s3');
        $imageFlag = $request->input('imageFlag');

        if($id != '') {
          //edit
          $job = JobItem::findOrFail($id);

          if(session()->has('data.file.edit_image') && is_array(session()->get('data.file.edit_image'))) {
            $edit_image_path_list = session()->get('data.file.edit_image');
            if(isset($edit_image_path_list['sub1'])) {
              if (File::exists(public_path() . $edit_image_path_list['sub1']) && $job->job_img2 != $edit_image_path_list['sub1']) {
                File::delete(public_path() . $edit_image_path_list['sub1']);
              }

              unset($edit_image_path_list['sub1']);
            }

          }

        } else {
          // 新規作成時
          $job = '';

          if(session()->has('data.file.image') && is_array(session()->get('data.file.image'))) {

            // もしセッションに画像がセットされている且つs3・ローカルにファイルが保存されていたら、削除
            $image_path_list = $this->JobItemRepo->existJobItemImageAndDeleteOnPost($imageFlag);
          }
        }

        $suffix = $request->input('data.File.suffix');

        // 画像ファイルをs3・ローカルに保存に保存
        $image_path = $this->JobItemRepo->saveJobItemImages($request->file('data.File.image'), $imageFlag);
        
        if($id != '') {
          $edit_image_path_list['sub1'] = $image_path;
          $request->session()->put('data.file.edit_image', $edit_image_path_list);

          return view('jobs.post.sub_image_complete', compact('job', 'suffix'));

        } else {
          $image_path_list['sub1'] = $image_path;
          $request->session()->put('data.file.image', $image_path_list);
        }

       
        return view('jobs.post.sub_image_complete', compact('job', 'suffix'));

      } else {
        return redirect()->back()->with('message_danger', '登録するサブ画像が選ばれていません');
      }

    }

    public function postSubImage2(SubImageUploadRequest $request, $id='')
    {
      if ($request->hasfile('data.File.image')) {

        $disk = Storage::disk('s3');
        $imageFlag = $request->input('imageFlag');


        if($id != '') {
          //edit
          $job = JobItem::findOrFail($id);

          if(session()->has('data.file.edit_image') && is_array(session()->get('data.file.edit_image'))) {
            $edit_image_path_list = session()->get('data.file.edit_image');
            if(isset($edit_image_path_list['sub2'])) {
              if (File::exists(public_path() . $edit_image_path_list['sub2']) && $job->job_img3 != $edit_image_path_list['sub2']) {
                File::delete(public_path() . $edit_image_path_list['sub2']);
              }

              unset($edit_image_path_list['sub2']);
            }

          }

        } else {
          // 新規作成時

          $job = '';

          if(session()->has('data.file.image') && is_array(session()->get('data.file.image'))) {
            
            // もしセッションに画像がセットされている且つs3・ローカルにファイルが保存されていたら、削除
            $image_path_list = $this->JobItemRepo->existJobItemImageAndDeleteOnPost($imageFlag);

          }
        }

        $suffix = $request->input('data.File.suffix');

         // 画像ファイルをs3・ローカルに保存に保存
        $image_path = $this->JobItemRepo->saveJobItemImages($request->file('data.File.image'), $imageFlag);

        if($id != '') {
          $edit_image_path_list['sub2'] = $image_path;
          $request->session()->put('data.file.edit_image', $edit_image_path_list);

          return view('jobs.post.sub_image_complete', compact('job', 'suffix'));

        } else {
          $image_path_list['sub2'] = $image_path;
          $request->session()->put('data.file.image', $image_path_list);
        }

        return view('jobs.post.sub_image_complete', compact('job', 'suffix'));

      } else {
        return redirect()->back()->with('message_danger', '登録するサブ画像が選ばれていません');
      }
    }

    public function subImageDelete1(Request $request, $id='')
    {

      $disk = Storage::disk('s3');
      $imageFlag = $request->imageflag;

      if($id != '') {
        // edit
        $job = JobItem::findOrFail($id);

        if(session()->has('data.file.edit_image.sub1') && is_array(session()->get('data.file.edit_image'))) {

          $edit_image_path_list = session()->get('data.file.edit_image');

          if (File::exists(public_path() . $edit_image_path_list['sub1']) && $job->job_img2 != $edit_image_path_list['sub1']) {
              File::delete(public_path() . $edit_image_path_list['sub1']);
          }

          if($job->job_img2 != null) {
            $edit_image_path_list['sub1'] = '';
          } else {
            unset($edit_image_path_list['sub1']);
          }

          session()->put('data.file.edit_image', $edit_image_path_list);

          return redirect()->back()->with('message_success', 'サブ写真を削除しました');

        } else {

          if($job->job_img2 != null) {
            session()->put('data.file.edit_image.sub1', '');
            return redirect()->back()->with('message_success', 'サブ写真を削除しました');
          }

          return redirect()->back()->with('message_danger', '削除するサブ写真はありません');
        }


      } else {
        // 新規作成時

        if (session()->has('data.file.image.sub1') && is_array(session()->get('data.file.image'))) {

         // もしセッションに画像がセットされている且つs3・ローカルにファイルが保存されていたら、削除
          $this->JobItemRepo->existJobItemImageAndDeleteOnDelete($imageFlag);


          return redirect()->back()->with('message_success', 'サブ写真を削除しました');

        } else {

          return redirect()->back()->with('message_danger', '削除するサブ写真はありません');

        }

      }

    }
    public function subImageDelete2(Request $request, $id='')
    {
      $disk = Storage::disk('s3');
      $imageFlag = $request->imageflag;

      if($id != '') {
        // edit
        $job = JobItem::findOrFail($id);

        if(session()->has('data.file.edit_image.sub2') && is_array(session()->get('data.file.edit_image'))) {

          $edit_image_path_list = session()->get('data.file.edit_image');

          if (File::exists(public_path() . $edit_image_path_list['sub2']) && $job->job_img3 != $edit_image_path_list['sub2']) {
              File::delete(public_path() . $edit_image_path_list['sub2']);
          }

          if($job->job_img3 != null) {
            $edit_image_path_list['sub2'] = '';
          } else {
            unset($edit_image_path_list['sub2']);
          }

          session()->put('data.file.edit_image', $edit_image_path_list);

          return redirect()->back()->with('message_success', 'サブ写真を削除しました');

        } else {

          if($job->job_img3 != null) {
            session()->put('data.file.edit_image.sub2', '');
            return redirect()->back()->with('message_success', 'サブ写真を削除しました');
          }

          return redirect()->back()->with('message_danger', '削除するサブ写真はありません');
        }


      } else {
        // 新規作成時

        if (session()->has('data.file.image.sub2') && is_array(session()->get('data.file.image'))) {

           // もしセッションに画像がセットされている且つs3・ローカルにファイルが保存されていたら、削除
          $this->JobItemRepo->existJobItemImageAndDeleteOnDelete($imageFlag);

          return redirect()->back()->with('message_success', 'サブ写真を削除しました');

        } else {

          return redirect()->back()->with('message_danger', '削除するサブ写真はありません');

        }

      }


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

    public function postMainMovie(MainMovieUploadRequest $request, $id='')
    {
      if($request->hasfile('data.File.movie')) {

        $disk = Storage::disk('s3');
        $movieFlag = $request->input('movieFlag');


        if($id != '') {
          //edit
          $job = JobItem::findOrFail($id);

          if(session()->has('data.file.edit_movie') && is_array(session()->get('data.file.edit_movie'))) {
            $edit_movie_path_list = session()->get('data.file.edit_movie');
            if(isset($edit_movie_path_list['main'])) {
              if (File::exists(public_path() . $edit_movie_path_list['main']) && $job->job_mov != $edit_movie_path_list['main']) {
                File::delete(public_path() . $edit_movie_path_list['main']);
              }

              unset($edit_movie_path_list['main']);
            }

          }

        } else {
          // 新規作成時

          $job = '';

          if(session()->has('data.file.movie') && is_array(session()->get('data.file.movie'))) {

            // もしセッションに動画がセットされている且つs3・ローカルにファイルが保存されていたら、削除
            $movie_path_list = $this->JobItemRepo->existJobItemMovieAndDeleteOnPost($movieFlag);

          }
        }

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

        if($id != '') {
          $edit_movie_path_list['main'] = $movie_path;
          $request->session()->put('data.file.edit_movie', $edit_movie_path_list);

          return view('jobs.post.main_movie_complete', compact('job'));

        } else {
          $movie_path_list['main'] = $movie_path;
          $request->session()->put('data.file.movie', $movie_path_list);
        }

        

        return view('jobs.post.main_movie_complete', compact('job'));

      } else {

        return redirect()->back()->with('message_danger', '登録するメイン動画が選ばれていません');

      }

    }

    public function mainMovieDelete(Request $request, $id='')
    {
      $disk = Storage::disk('s3');
      $movieFlag = $request->movieflag;

      if($id != '') {
        // edit

        $job = JobItem::findOrFail($id);

        if(session()->has('data.file.edit_movie.main') && is_array(session()->get('data.file.edit_movie'))) {

          $edit_movie_path_list = session()->get('data.file.edit_movie');

          if($edit_movie_path_list['main'] == '') {
            return redirect()->back()->with('message_danger', '削除するメイン動画はありません');
          }

          if (File::exists(public_path() . $edit_movie_path_list['main']) && $job->job_mov != $edit_movie_path_list['main']) {
              File::delete(public_path() . $edit_movie_path_list['main']);
          }

          if($job->job_mov != null) {
            $edit_movie_path_list['main'] = '';
          } else {
            unset($edit_movie_path_list['main']);
          }

          session()->put('data.file.edit_movie', $edit_movie_path_list);

          return redirect()->back()->with('message_success', 'メイン動画を削除しました');

        } else {

          if($job->job_mov != null) {
            session()->put('data.file.edit_movie.main', '');
            return redirect()->back()->with('message_success', 'メイン動画を削除しました');
          }

          return redirect()->back()->with('message_danger', '削除するメイン動画はありません');

        }

      } else {
        // 新規作成時

        if (session()->has('data.file.movie.main') && is_array(session()->get('data.file.movie'))) {

           // もしセッションに動画がセットされている且つs3・ローカルにファイルが保存されていたら、削除
           $this->JobItemRepo->existJobItemMovieAndDeleteOnDelete($movieFlag);

          return redirect()->back()->with('message_success', 'メイン動画を削除しました');

        } else {
          return redirect()->back()->with('message_danger', '削除するメイン動画はありません');
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

    public function postSubMovie1(MainMovieUploadRequest $request, $id='')
    {

      if($request->hasfile('data.File.movie')) {

        $disk = Storage::disk('s3');
        $movieFlag = $request->movieFlag;


        if($id != '') {
          //edit
          $job = JobItem::findOrFail($id);

          if(session()->has('data.file.edit_movie') && is_array(session()->get('data.file.edit_movie'))) {
            $edit_movie_path_list = session()->get('data.file.edit_movie');
            if(isset($edit_movie_path_list['sub1'])) {
              if (File::exists(public_path() . $edit_movie_path_list['sub1']) && $job->job_mov2 != $edit_movie_path_list['sub1']) {
                File::delete(public_path() . $edit_movie_path_list['sub1']);
              }

              unset($edit_movie_path_list['sub1']);
            }

          }

        } else {
          // 新規作成時
          $job = '';
          if(session()->has('data.file.movie') && is_array(session()->get('data.file.movie'))) {
            
             // もしセッションに動画がセットされている且つs3・ローカルにファイルが保存されていたら、削除
             $movie_path_list = $this->JobItemRepo->existJobItemMovieAndDeleteOnPost($movieFlag);

          }
        }

        $suffix = $request->input('data.File.suffix');

        // 動画ファイルをs3・ローカルに保存に保存
        $movie_path = $this->JobItemRepo->saveJobItemMovies($request->file('data.File.movie'), $movieFlag);


        if($id != '') {
          $edit_movie_path_list['sub1'] = $movie_path;
          $request->session()->put('data.file.edit_movie', $edit_movie_path_list);

          return view('jobs.post.sub_movie_complete', compact('job', 'suffix'));

        } else {
          $movie_path_list[$movieFlag] = $movie_path;
          $request->session()->put('data.file.movie', $movie_path_list);
        }


        // 登録完了画面を返す
        if($movieFlag == 'main') {
          return view('jobs.post.main_movie_complete', compact('job', 'suffix'));
        } else {
          return view('jobs.post.sub_movie_complete', compact('job', 'suffix'));
        }

      } else {

        if($movieFlag == 'main') {
          return redirect()->back()->with('message_danger', '登録するメイン動画が選ばれていません');
        } else {
          return redirect()->back()->with('message_danger', '登録するサブ動画が選ばれていません');
        }
      
      }

    }

    public function postSubMovie2(MainMovieUploadRequest $request, $id='')
    {
      if ($request->hasfile('data.File.movie')) {
        
        $disk = Storage::disk('s3');
        $movieFlag = $request->movieFlag;

        if($id != '') {
          //edit
          $job = JobItem::findOrFail($id);

          if(session()->has('data.file.edit_movie') && is_array(session()->get('data.file.edit_movie'))) {
            $edit_movie_path_list = session()->get('data.file.edit_movie');
            if(isset($edit_movie_path_list['sub2'])) {
              if (File::exists(public_path() . $edit_movie_path_list['sub2']) && $job->job_mov3 != $edit_movie_path_list['sub2']) {
                File::delete(public_path() . $edit_movie_path_list['sub2']);
              }

              unset($edit_movie_path_list['sub2']);
            }

          }

        } else {
          // 新規作成時
          $job = '';

          if(session()->has('data.file.movie') && is_array(session()->get('data.file.movie'))) {
            
             // もしセッションに動画がセットされている且つs3・ローカルにファイルが保存されていたら、削除
             $movie_path_list = $this->JobItemRepo->existJobItemMovieAndDeleteOnPost($movieFlag);

          }
        }

        $suffix = $request->input('data.File.suffix');

        // 動画ファイルをs3・ローカルに保存に保存
        $movie_path = $this->JobItemRepo->saveJobItemMovies($request->file('data.File.movie'), $movieFlag);


        if($id != '') {
          $edit_movie_path_list['sub2'] = $movie_path;
          $request->session()->put('data.file.edit_movie', $edit_movie_path_list);

          return view('jobs.post.sub_movie_complete', compact('job', 'suffix'));

        } else {
          $movie_path_list['sub2'] = $movie_path;
          $request->session()->put('data.file.movie', $movie_path_list);
        }

        return view('jobs.post.sub_movie_complete', compact('job', 'suffix'));

      } else {

        return redirect()->back()->with('message_danger', '登録するサブ動画が選ばれていません');

      }
    }

    public function subMovieDelete1(Request $request, $id='')
    {
      $disk = Storage::disk('s3');
      $movieFlag = $request->movieflag;

      if($id != '') {
        // edit

        $job = JobItem::findOrFail($id);

        if(session()->has('data.file.edit_movie.sub1') && is_array(session()->get('data.file.edit_movie'))) {

          $edit_movie_path_list = session()->get('data.file.edit_movie');

          if (File::exists(public_path() . $edit_movie_path_list['sub1']) && $job->job_mov2 != $edit_movie_path_list['sub1']) {
              File::delete(public_path() . $edit_movie_path_list['sub1']);
          }

          if($job->job_mov2 != null) {
            $edit_movie_path_list['sub1'] = '';
          } else {
            unset($edit_movie_path_list['sub1']);
          }

          session()->put('data.file.edit_movie', $edit_movie_path_list);

          return redirect()->back()->with('message_success', 'サブ動画を削除しました');

        } else {

          if($job->job_mov2 != null) {
            session()->put('data.file.edit_movie.sub1', '');
            return redirect()->back()->with('message_success', 'サブ動画を削除しました');
          }

          return redirect()->back()->with('message_danger', '削除するサブ動画はありません');

        }

      } else {
          // 新規作成時

          if (session()->has('data.file.movie.sub1') && is_array(session()->get('data.file.movie'))) {

            // もしセッションに動画がセットされている且つs3・ローカルにファイルが保存されていたら、削除
            $this->JobItemRepo->existJobItemMovieAndDeleteOnDelete($movieFlag);

            return redirect()->back()->with('message_success', 'サブ動画を削除しました');

          } else {
            return redirect()->back()->with('message_danger', '削除するサブ動画はありません');
          }

      }

    }

    public function subMovieDelete2(Request $request, $id='')
    {
      $disk = Storage::disk('s3');
      $movieFlag = $request->movieflag;

      var_dump($movieFlag);

      if($id != '') {
        // edit

        $job = JobItem::findOrFail($id);

        if (session()->has('data.file.edit_movie.sub2') && is_array(session()->get('data.file.edit_movie'))) {

          $edit_movie_path_list = session()->get('data.file.edit_movie');

          if (File::exists(public_path() . $edit_movie_path_list['sub2']) && $job->job_mov3 != $edit_movie_path_list['sub2']) {
              File::delete(public_path() . $edit_movie_path_list['sub2']);
          }

          if($job->job_mov3 != null) {
            $edit_movie_path_list['sub2'] = '';
          } else {
            unset($edit_movie_path_list['sub2']);
          }

          session()->put('data.file.edit_movie', $edit_movie_path_list);

          return redirect()->back()->with('message_success', 'サブ動画を削除しました');

        } else {

          if($job->job_mov3 != null) {
            session()->put('data.file.edit_movie.sub2', '');
            return redirect()->back()->with('message_success', 'サブ動画を削除しました');
          }

          return redirect()->back()->with('message_danger', '削除するサブ動画はありません');
        }

      } else {
        // 新規作成時

        if (session()->has('data.file.movie.sub2') && is_array(session()->get('data.file.movie'))) {

           // もしセッションに動画がセットされている且つs3・ローカルにファイルが保存されていたら、削除
           $this->JobItemRepo->existJobItemMovieAndDeleteOnDelete($movieFlag);

          return redirect()->back()->with('message_success', 'サブ動画を削除しました');

        } else {
          return redirect()->back()->with('message_danger', '削除するサブ動画はありません');
        }

      }
    }
}
