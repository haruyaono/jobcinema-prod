<?php

namespace App\Http\Controllers\API;

use App\Services\JobItemSearchService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobItemController extends Controller
{
  private $JobItemSearchService;

  public function __construct(
    JobItemSearchService $jobItemSearchService
  ) {
    $this->JobItemSearchService = $jobItemSearchService;
  }

  public function index(Request $request)
  {
    $params = $request->all();
    $query = $this->JobItemSearchService->search($params);

    return response()->json(['jobitems' => $query->get()]);
  }
}
