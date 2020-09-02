<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Model\Registration;
use Input, Redirect;
use DB;

class RegistrationController extends Controller
{
    public function index() { 

    $details=DB::table('registration')->get();
    
   	//$details=Registration::all();
        

      return view('register',compact('details')); 
     }  

    public function store(Request $request)

    {  

        request()->validate([

        'name' => 'required',

        'email' => 'required',

        'phone_no' => 'required'

        ]);

         

        //$data = $request->all();

        $data = request()->except(['_token']);

        $check = Registration::insert($data);

        $arr = array('msg' => 'Something goes to wrong. Please try again lator', 'status' => false);

        if($check){ 

        $arr = array('msg' => 'Successfully submit form using ajax', 'status' => true);

        }

        return Response()->json($arr);

       

    }



}
