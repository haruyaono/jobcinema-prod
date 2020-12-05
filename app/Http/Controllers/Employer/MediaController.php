<?php

namespace App\Http\Controllers\Employer;

use function App\Helpers\getIdentifier;
use Illuminate\Http\Request;
use App\Models\JobItem;
use App\Http\Requests\Media\ImageUploadRequest;
use App\Http\Requests\Media\MovieUploadRequest;
use App\Services\MediaMetadataService;
use App\Services\S3Service;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
  private $mediaMetadataService;
  private $s3Service;

  public function __construct(
    MediaMetadataService $mediaMetadataService,
    S3Service $s3Service
  ) {
    $this->mediaMetadataService = $mediaMetadataService;
    $this->s3Service = $s3Service;
  }

  public function editMainImage(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    $images = $this->s3Service->getJobItemImagePublicUrl($jobitem);
    return view('companies.job_sheet.image.main_image', compact('jobitem', 'images'));
  }

  public function editSubImage1(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    $images = $this->s3Service->getJobItemImagePublicUrl($jobitem);
    return view('companies.job_sheet.image.sub_image_01', compact('jobitem', 'images'));
  }

  public function editSubImage2(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    $images = $this->s3Service->getJobItemImagePublicUrl($jobitem);
    return view('companies.job_sheet.image.sub_image_02', compact('jobitem', 'images'));
  }

  public function updateImage(ImageUploadRequest $request, JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    $imageFlag = $request->input('data.File.suffix');

    $this->mediaMetadataService->writeJobItemImage(
      $jobitem,
      $request->getFileContent(),
      $request->getFileExtension(),
      $imageFlag
    );

    $this->s3Service->uploadJobItemImage(
      $jobitem,
      file_get_contents($this->mediaMetadataService->getJobItemImagelUrl($jobitem, $imageFlag)),
      $imageFlag
    );

    if ($imageFlag == '1') {
      return view('companies.job_sheet.image.main_image_complete', compact('jobitem'));
    }
    return view('companies.job_sheet.image.sub_image_complete', compact('jobitem', 'imageFlag'));
  }

  public function deleteImage(Request $request, JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    $imageFlag = (int) $request->flag;

    $this->mediaMetadataService->deleteJobItemImageFiles($jobitem, $imageFlag);

    $jobitem->update([
      'job_img_' . $imageFlag => null
    ]);

    if ($imageFlag == '1') {
      return redirect()->back()->with('message_success', 'メイン写真を削除しました');
    } else {
      return redirect()->back()->with('message_success', 'サブ写真を削除しました');
    }
  }

  public function editMainMovie(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    $movies = $this->s3Service->getJobItemMoviePublicUrl($jobitem);
    return view('companies.job_sheet.movie.main_movie', compact('jobitem', 'movies'));
  }

  public function editSubMovie1(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    $movies = $this->s3Service->getJobItemMoviePublicUrl($jobitem);
    return view('companies.job_sheet.movie.sub_movie_01', compact('jobitem', 'movies'));
  }

  public function editSubMovie2(JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    $movies = $this->s3Service->getJobItemMoviePublicUrl($jobitem);
    return view('companies.job_sheet.movie.sub_movie_02', compact('jobitem', 'movies'));
  }

  public function updateMovie(MovieUploadRequest $request, JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);
    $movieFlag = $request->input('data.File.suffix');

    $identifier = getIdentifier($movieFlag);
    if ($identifier == '') return;

    $this->s3Service->deleteJobItemMovie(
      $jobitem,
      $movieFlag,
      $identifier
    );

    $this->mediaMetadataService->writeJobItemMovie(
      $jobitem,
      $request->getFileContent(),
      $movieFlag,
      $identifier
    );

    $this->s3Service->uploadJobItemMovie(
      $jobitem,
      file_get_contents($this->mediaMetadataService->getJobItemMovielUrl($jobitem, $identifier, $movieFlag)),
      $movieFlag,
      $identifier
    );

    if ($movieFlag == '1') {
      return view('companies.job_sheet.movie.main_movie_complete', compact('jobitem'));
    } else {
      return view('companies.job_sheet.movie.sub_movie_complete', compact('jobitem', 'movieFlag'));
    }
  }

  public function deleteMovie(Request $request, JobItem $jobitem)
  {
    $this->authorize('view', $jobitem);

    $movieFlag = $request->input('flag');
    $identifier = getIdentifier($movieFlag);
    if ($identifier == '') return;

    $this->s3Service->deleteJobItemMovie(
      $jobitem,
      $movieFlag,
      $identifier
    );

    $this->mediaMetadataService->deleteJobItemMovieFiles(
      $jobitem,
      $identifier,
      $movieFlag
    );

    $jobitem->update([
      'job_mov_' . $movieFlag => null
    ]);

    if ($movieFlag == '1') {
      return redirect()->back()->with('message_success', 'メイン動画を削除しました');
    } else {
      return redirect()->back()->with('message_success', 'サブ動画を削除しました');
    }
  }
}
