<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ApiController extends Controller
{
    public function index(Request $request)
    {
        //
        try 
        {

            //return 'hello';
            $data =$request->all();
                $List=\App\Model\Registration::List();
                if($List)
                {
                    
                    return response()->json(['data' =>$List,'message' =>' List'], 200);
                }
                else
                {
                    return response()->json(['data' =>null,'message' =>'List not Found'], 400);
                }
        }   
         catch(\Exception $e){
             return response()->json(['data' =>null,'error' =>$e->getMessage()], 400);
        }
        

    


    }

}
