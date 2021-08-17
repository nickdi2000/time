<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Dealer;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $token = auth()->login($user);
        return response()->json(compact('token', 'user'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
				$courseName = isset($data['golf_course']['name']) ? $data['golf_course']['name'] : $data['golf_course'];

				if(!isset( $data['golf_course']['id'] )){
					$course = Course::create([
						'name' => $data['golf_course']
					]);
					$course->save();
					$courseId = $course->id;
				}else{
					$courseId = $data['golf_course']['id'];
				}

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
						'user_type' => $data['user_type'],
						'golf_course' => $courseName,
						'golf_course_id' => $courseId,
            'password' => bcrypt($data['password']),
        ]);
    }
}
