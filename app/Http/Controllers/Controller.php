<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Traits\ApiHandler;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiHandler;

		 public function validateRecord($data){
        return Validator::make(request()->all(), $data);
    }

    public function store(Request $request)
    {
      $data = $request->toArray();
      $data['hole'] = "3";

      $record = $this->model::create($data);
      return $this->successResponse($record);
    }

}
