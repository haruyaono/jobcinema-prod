<?php


namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use App\Job\Users\User;
use App\Job\Users\Repositories\UserRepository;
use App\Job\JobItems\JobItem;
use App\Job\Companies\Company;
use Illuminate\Support\Facades\Auth;
use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use DB;

class JobController extends Controller
{

    /**
     * @var CategoryRepositoryInterface
     * @var JobItemRepositoryInterface
    *  @var UserRepositoryInterface
     */
    private $categoryRepo;
    private $jobItemRepo;
    private $userRepo;

    private $job_form_session = 'count';
    private $JobItem;
    
  
     /**
     * JobController constructor.
     * @param JobItem $JobItem
     * @param CategoryRepositoryInterface $categoryRepository
     * @param JobItemRepositoryInterface $jobItemRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
      JobItem $JobItem, 
      CategoryRepositoryInterface $categoryRepository,
      JobItemRepositoryInterface $jobItemRepository,
      UserRepositoryInterface $userRepository
    ) {

      $this->JobItem = $JobItem;
      $this->categoryRepo = $categoryRepository;
      $this->jobItemRepo = $jobItemRepository;
      $this->userRepo = $userRepository;
    }

    public function index(Request $request)
    {

      $query = $this->JobItem->activeJobitem()->with('categories');

      return response()->json(['data' => $query->latest()->get()]);
    }

}

