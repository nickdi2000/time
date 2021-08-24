<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Validation\ValidatesRequests;


trait ApiHandler {

	//as we all know, 200 is our success message, so this is hardresponseCoded in
  protected function successResponse($data, $message = 'Success', $responseCode = 200)
	{
		return response()->json([
			'status'=> 'success',
			'message' => $message,
			'data' => $data,
		], $responseCode);
	}

	//we will pass the response code if it is an error
	protected function errorResponse($message = 'Uh oh..Something bad happened', $responseCode) //we should  send a msg as parameter here
	{
		//or if we wanted to, we could override default messsages for the rrors too.., (we would send the $message default paramater value as null)
		/*
		$defaultMessages = [
				'403' => 'Forbidden Access!',
				'404' => 'Oh no, not found',
				// .. and so on
		];
		 $message = ($message == null) ? $defaultMessages[$responseCode] : 'Something went wrong, this is default message';
		 */

		return response()->json([
			'status'=>'error',
			'message' => $message, //could be array/object
			'data' => null,
		], $responseCode);
	}




}
