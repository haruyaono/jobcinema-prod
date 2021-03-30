<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
  public function getLp()
  {
    return view('pages.lp');
  }

  public function getBeginner()
  {
    return view('pages.beginners');
  }

  public function getTermsService()
  {
    return view('pages.terms_service');
  }
  public function getTermsServiceE()
  {
    return view('pages.terms_service_e');
  }
  public function getCeo()
  {
    return view('pages.ceo');
  }
  public function getInfo()
  {
    return view('pages.info');
  }
  public function getManageAbout()
  {
    return view('pages.manage_about');
  }
}
