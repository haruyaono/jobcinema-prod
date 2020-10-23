<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Job\JobItems\JobItem;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
  private $JobItem;

  /**
   * JobController constructor.
   * @param JobItem $JobItem
   */
  public function __construct(
    JobItem $JobItem
  ) {
    $this->JobItem = $JobItem;
  }

  public function index()
  {
    $query = $this->JobItem->activeJobitem()->with('categories');

    return response()->json(['data' => $query->latest()->get()]);
  }
}
