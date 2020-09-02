<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Model\Registration;
use Input, Redirect;
use DB;
use Session;

class RegistrationController extends Controller
{
    public function index() { 
    $details=DB::table('registration')->where('verify','1')->get();
    
    return view('register',compact('details')); 
     }  

    public function store(Request $request)
    {  
        request()->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_no' => 'required'
        ]);

            $data = request()->except(['_token']);

            $data['otp']    = rand(1, 10000);
        
            $check = Registration::insert($data);

            Session::put('phone_no', $data['phone_no']);
            Session::put('otp', $data['otp']);

            $msg = "This is otp : ".$data['otp'];
            $data1['displayMessage']=$msg;
            $data1['phone_no']=$data['phone_no'];

            $this->smsDetails($data1);

            $arr = array('msg' => 'Something goes to wrong. Please try again lator', 'status' => false);

        if($check){ 

        $arr = array('msg' => 'Otp sent suceessfully', 'status' => true, 'code' => 200);

        }

        return Response()->json($arr);
    }


    public function verify(Request $request){

        $data = $request->all();
    
        if($data['otp'] == Session::get('otp')){
            
            $update_type  = Registration::where('otp', Session::get('otp'))->update([
           'verify' => '1']);
            
            $arr = array('msg' => 'Otp verify suceessfully.', 'status' => true, 'statusCode' => 200);
            return Response()->json($arr);

       }
       else
       {

            $arr = array('msg' => 'Invalid OTP.', 'status' => false);
            return Response()->json($arr);

       }
    }

    public function smsDetails($data)
    {

        $authKey = "340534AuQUf1EB5f4f3fb2P1";
        $senderId = "INSO101";
        $route = 4;
        $result = ""; 
      
        $no=$data['phone_no'];
        $message = urlencode($data['displayMessage']);
        $postData = array(
            'authkey' => $authKey,
            'mobiles' =>$no,
            'message' => $message,
            'sender' => $senderId,
            'route' => $route
        );

        $url="http://api.msg91.com/api/sendhttp.php";

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ));

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $output = curl_exec($ch);
    
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
    }



}
