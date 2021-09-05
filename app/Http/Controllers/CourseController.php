<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Repository\Courses;

use App\Models\Course;
use App\User;

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

      // Get Course with all players data.

			public function show($id)
			{
				//$course = Course::where('id', $id)->with('players')->get();
        $course = Course::find($id);
				return response()->json($course);
			}


			public function update(Request $request, $id)
			{
				$data = $request->toArray();
				$course = Course::findOrFail($id);
				$course->update($data);
				$return = $course->save();
				return $this->successResponse($return, "Course Successfully Updated");

			}

			public function myCourse()
			{
					$course = Course::find(1);
					return response()->json($course);
			}

      public function getCourseByCode($code)
			{
					$course = Course::where("code", $code)->first();

          if(!$course){
            return 0;
          }
					return response()->json($course);
			}

}
