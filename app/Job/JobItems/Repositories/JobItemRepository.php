<?php

namespace App\Job\JobItems\Repositories;

use App\Job\JobItemImages\JobItemImage;
use App\Job\JobItems\JobItem;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Image;
use Storage;
use File;

class JobItemRepository implements JobItemRepositoryInterface
{

    // private $disk;
    /**
     * JobItemRepository constructor.
     * @param JobItem $jobItem
     */
    public function __construct(JobItem $jobItem)
    {
        $this->model = $jobItem;
        // $this->disk = Storage::disk('s3');
    }




    /**
     * @param string $imageFlag
     *
     * @return void
     */
    public function existJobItemImageAndDeleteOnPost($imageFlag)
    {
        $disk = Storage::disk('s3');

        $image_path_list = session()->get('data.file.image');

        if($imageFlag == 'main') {
            if(isset($image_path_list['main'])) {
                if (File::exists(public_path() . $image_path_list['main'])) {
                    File::delete(public_path() . $image_path_list['main']);
                }

                if($disk->exists($image_path_list['main'])) {
                    $disk->delete($image_path_list['main']);
                }

                unset($image_path_list['main']);
                echo 'mainだよ';
            }
            
        } elseif($imageFlag == 'sub1') {
            if(isset($image_path_list['sub1'])) {
                if (File::exists(public_path() . $image_path_list['sub1'])) {
                  File::delete(public_path() . $image_path_list['sub1']);
                }
  
                if($disk->exists($image_path_list['sub1'])) {
                  $disk->delete($image_path_list['sub1']);
                }
  
                unset($image_path_list['sub1']);
                echo 'sub1だよ';
            }
            
        } elseif($imageFlag == 'sub2') {
            if(isset($image_path_list['sub2'])) {
                if (File::exists(public_path() . $image_path_list['sub2'])) {
                  File::delete(public_path() . $image_path_list['sub2']);
                }
  
                if($disk->exists($image_path_list['sub2'])) {
                  $disk->delete($image_path_list['sub2']);
                }
  
                unset($image_path_list['sub2']);
            }
        }

        return $image_path_list;

       
    }

    /**
     * @param UploadedFile $file
     *
     * @return $image_path
     */
    public function saveJobItemImages(UploadedFile $file, $imageFlag) : string
    {
        $disk = Storage::disk('s3');

        $resize_image = Image::make($file)->widen(300);

        switch ($imageFlag) {
            case $imageFlag == 'main':
                $image_name = uniqid("main_image").".".$file->guessExtension();
                break;
            case $imageFlag == 'sub1':
                $image_name = uniqid("sub1_image").".".$file->guessExtension();
                break;
            case $imageFlag == 'sub2':
                $image_name = uniqid("sub2_image").".".$file->guessExtension();
                break;
            default:
                $image_name = $file->hashname();
        }

        // ファイルを保存
        $resize_image->save(public_path(\Config::get('fpath.tmp_img').$image_name));
       
        // ファイルパスを取得
        $image_path = \Config::get('fpath.tmp_img').$image_name;

        // ファイル情報を取得
        $imageContents = File::get(public_path(\Config::get('fpath.tmp_img').$image_name));

        $disk->put($image_path, $imageContents, 'public');

        return $image_path;
    }


    /**
     * @param string $imageFlag
     *
     * @return void
     */
    public function existJobItemImageAndDeleteOnDelete($imageFlag)
    {
        $disk = Storage::disk('s3');

        $image_path_list = session()->get('data.file.image');

        switch ($imageFlag) {
            case $imageFlag == 'main':

                if (File::exists(public_path() . $image_path_list['main'])) {
                  File::delete(public_path() . $image_path_list['main']);
                }
                if($disk->exists($image_path_list['main'])) {
                  $disk->delete($image_path_list['main']);
                }
  
                unset($image_path_list['main']);
                break;

            case $imageFlag == 'sub1':

                if (File::exists(public_path() . $image_path_list['sub1'])) {
                    File::delete(public_path() . $image_path_list['sub1']);
                }
                if($disk->exists($image_path_list['sub1'])) {
                    $disk->delete($image_path_list['sub1']);
                }

                unset($image_path_list['sub1']);
                break;

            case $imageFlag == 'sub2':
                if (File::exists(public_path() . $image_path_list['sub2'])) {
                    File::delete(public_path() . $image_path_list['sub2']);
                }
                if($disk->exists($image_path_list['sub2'])) {
                    $disk->delete($image_path_list['sub2']);
                }

                unset($image_path_list['sub2']);
                break;
        }

        session()->put('data.file.image', $image_path_list);
    }

   
}