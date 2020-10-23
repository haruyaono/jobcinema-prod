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

  public function editMainImage(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    return view('companies.job_sheet.image.main_image', compact('jobitem'));
  }

  public function editSubImage1(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    return view('companies.job_sheet.image.sub_image_01', compact('jobitem'));
  }

  public function editSubImage2(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    return view('companies.job_sheet.image.sub_image_02', compact('jobitem'));
  }

  public function updateImage(ImageUploadRequest $request, JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);

    $disk = Storage::disk('s3');
    $imageFlag = (int) $request->input('data.File.suffix');

    if ($request->hasfile('data.File.image')) {

      $image = Image::make($request->file('data.File.image'))->widen(300);

      if ($imageFlag !== null) {
        $imageName = "img_" . $jobitem->id . "_" . $imageFlag . '.jpg';
      } else {
        $imageName = $image->hashName();
      }

      $path = \Config::get('fpath.job_sheet_img') . $imageName;

      if ($disk->exists($path)) {
        $disk->delete($path);
      }
      if (File::exists(public_path() . $path)) {
        File::delete(public_path() . $path);
      }

      $image->save(public_path($path));

      $imageContents = File::get(public_path($path));


      $disk->put($path, $imageContents, 'public');

      $jobitem->update([
        'job_img_' . $imageFlag => $imageName,
      ]);

      if ($imageFlag === 1) {
        return view('companies.job_sheet.image.main_image_complete', compact('jobitem'));
      } else {
        return view('companies.job_sheet.image.sub_image_complete', compact('jobitem', 'imageFlag'));
      }
    } else {

      if ($imageFlag === 1) {
        return redirect()->back()->with('message_danger', '登録するメイン画像が選ばれていません');
      } else {
        return redirect()->back()->with('message_danger', '登録するサブ画像が選ばれていません');
      }
    }
  }

  public function deleteImage(Request $request, JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);

    $disk = Storage::disk('s3');
    $imageFlag = (int) $request->flag;

    switch ($imageFlag) {
      case $imageFlag === 1:
        $imageName = $jobitem->job_img_1;
        break;
      case $imageFlag === 2:
        $imageName = $jobitem->job_img_2;
        break;
      case $imageFlag === 3:
        $imageName = $jobitem->job_img_3;
        break;
      default:
        $imageName = null;
    }

    $path = \Config::get('fpath.job_sheet_img') . $imageName;

    if ($disk->exists($path)) {
      $disk->delete($path);
    }
    if (File::exists(public_path() . $path)) {
      File::delete(public_path() . $path);
    }

    $jobitem->update([
      'job_img_' . $imageFlag => null
    ]);

    if ($imageFlag === 1) {
      return redirect()->back()->with('message_success', 'メイン写真を削除しました');
    } else {
      return redirect()->back()->with('message_success', 'サブ写真を削除しました');
    }
  }

  public function editMainMovie(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    return view('companies.job_sheet.movie.main_movie', compact('jobitem'));
  }

  public function editSubMovie1(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    return view('companies.job_sheet.movie.sub_movie_01', compact('jobitem'));
  }

  public function editSubMovie2(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    return view('companies.job_sheet.movie.sub_movie_02', compact('jobitem'));
  }

  public function updateMovie(MovieUploadRequest $request, JobItem $jobitem)
  {

    $this->authorize('view', $jobitem);

    $disk = Storage::disk('s3');
    $movieFlag = (int) $request->input('data.File.suffix');

    if ($request->hasfile('data.File.movie')) {

      $movie = $request->file('data.File.movie');

      if ($movieFlag !== null) {
        $movieName = "mov_" . $jobitem->id . "_" . $movieFlag . '.' . $movie->guessExtension();
      } else {
        $movieName = $movie->hashName();
      }

      $path = \Config::get('fpath.job_sheet_mov') . $movieName;

      if ($disk->exists($path)) {
        $disk->delete($path);
      }
      if (File::exists(public_path() . $path)) {
        File::delete(public_path() . $path);
      }

      $movie->move(public_path() . \Config::get('fpath.job_sheet_mov'), $movieName);

      $movieContents = File::get(public_path($path));

      $disk->put($path, $movieContents, 'public');

      $jobitem->update([
        'job_mov_' . $movieFlag => $movieName,
      ]);

      if ($movieFlag === 1) {
        return view('companies.job_sheet.movie.main_movie_complete', compact('jobitem'));
      } else {
        return view('companies.job_sheet.movie.sub_movie_complete', compact('jobitem', 'movieFlag'));
      }
    } else {

      if ($movieFlag === 1) {
        return redirect()->back()->with('message_danger', '登録するメイン動画が選ばれていません');
      } else {
        return redirect()->back()->with('message_danger', '登録するサブ動画が選ばれていません');
      }
    }
  }

  public function deleteMovie(Request $request, JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);

    $disk = Storage::disk('s3');
    $movieFlag = (int) $request->flag;

    switch ($movieFlag) {
      case $movieFlag === 1:
        $movieName = $jobitem->job_mov_1;
        break;
      case $movieFlag === 2:
        $movieName = $jobitem->job_mov_2;
        break;
      case $movieFlag === 3:
        $movieName = $jobitem->job_mov_3;
        break;
      default:
        $movieName = null;
    }

    $path = \Config::get('fpath.job_sheet_mov') . $movieName;

    if ($disk->exists($path)) {
      $disk->delete($path);
    }
    if (File::exists(public_path() . $path)) {
      File::delete(public_path() . $path);
    }

    $jobitem->update([
      'job_mov_' . $movieFlag => null
    ]);

    if ($movieFlag === 1) {
      return redirect()->back()->with('message_success', 'メイン動画を削除しました');
    } else {
      return redirect()->back()->with('message_success', 'サブ動画を削除しました');
    }
  }
}
