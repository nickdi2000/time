<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Mail;

trait EmailHandler {

  protected function sendEmail($contents = [])
	{

    $body = "Beta requets signup submitted from ";// . $contents->email;

    $data = [
        'body' => $body,
        'app_url' => env('APP_URL'),
      ];

      Mail::send('mail', $data, function ($message) {
        $message->from('system@webfly.io', env('APP_NAME'));
        $message->subject('BETA SIGNUP');
        $message->to('nickdifelice+timetrialsbeta@gmail.com');
      });
	}

}
