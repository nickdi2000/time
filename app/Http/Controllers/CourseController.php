<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Repository\Courses;

use App\Models\Course;

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

			public function myCourse()
			{
					$course = Course::find(1);
					return response()->json($course);
			}
}
