<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait SendEmail
{ 
    use GeneralTrait;



    public function sendEmail($data=[],$email,$blade,$subject)  
    {  
        try {
            
            Mail::send($blade,$data ,function($message) use($email,$subject) 
            {
                $message -> subject($subject);
                $message->to($email);
            });
        } catch (\Throwable $th) {
            $this->returnError($th->getMessage());
        }
    }




}
