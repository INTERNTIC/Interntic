<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait SendEmail
{ 



    public function sendEmail($data=[],$email,$blade,$subject)  
    {  
        Mail::send($blade,$data ,function($message) use($email,$subject) 
        {
            $message -> subject($subject);
            $message->to($email);
        });
    }




}
