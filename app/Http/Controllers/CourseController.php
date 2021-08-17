<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Repository\Courses;

class CourseController extends Controller
{

    public function index()
    {
    		$courses = Courses::all();
        return response()->json($courses);
    }

		  public function list()
	    {
	    		$courses = Courses::all('name');

					foreach($courses as $c){
						echo $c->name . "<br>";
					}
	    }
}
