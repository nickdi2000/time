<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Traits\ApiHandler;
use App\Traits\EmailHandler;
use App\Registration;
use App\Race;

class PageController extends BaseController
{
  use EmailHandler;

  public function index(Request $request, $page)
  {
    $race = Race::where('code', $page)->first();

    if($race->count()){
      $data['race'] = $race;
      return view('app', $data);
    }

    return "No races found with code " . $page;
  }

  public function landing()
  {
    $data['app_name'] = env('APP_NAME');
    return view('pages.signup', $data);
  }


  public function apply(Request $request)
  {

    $data = $request->all();
    $data['app_name'] = env('APP_NAME');
    $reg = Registration::create($data);
    $reg->save();

    //$this->sendEmail($data);
    return view('pages.thankyou', $data);
  }


}
