<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{

    public function index(Request $request)
    {
    		$courses = Course::all();
        return response()->json($courses);
    }
}
