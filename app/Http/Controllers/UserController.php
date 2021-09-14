<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\User;

class UserController extends Controller
{

    protected $model = User::class;

    public function index()
    {
    		$users = User::with('course')->get();
        return response()->json($users);
    }

		  public function list()
	    {
	    		$users = User::all('name');

					foreach($users as $c){
						echo $c->name . "<br>";
					}
	    }

			public function show($id)
			{
				$user = User::find($id);
				return response()->json($user);
			}

			public function myCourse()
			{
          $user = auth()->user();
					$course = User::where('id', $user->id)->with('course')->get()->pluck('course');
					return response()->json($course[0]);
			}


			public function myUser()
			{
					$user = User::find(1);
					return response()->json($user);
			}
}
