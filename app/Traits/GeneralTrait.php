<?php

namespace App\Traits;

trait GeneralTrait
{ 

    public function getCurrentLang()  
    {
        return app()->getLocale();
    }


    public function returnError($msg,$code=450,$errors=[])  

    {
        return response()->json([
            'status' => false,
            'code' => $code,
            'msg' => $msg,
            'errors' => $errors
        ],$code);
    }


    public function returnSuccessMessage($msg, $code = 200)
    {
        return response()->json([
            'status' => true,
            'code' => $code,
            'msg' => $msg
        ],$code);
        
    }

    public function returnData($value, $msg = "Success",$code=200,$status=true)
    {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'msg' => $msg,
            'data' => $value
        ],$code);
    }

}
