<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
class AdminApiController extends Controller
{
   
    public function studentApprove(Request $request, $id)
    {
        

                    // dd($id);
      
                    header("Access-Control-Allow-Origin: *");
                    //ALLOW OPTIONS METHOD
                    $headers = [
                        'Access-Control-Allow-Methods' => 'POST,GET,OPTIONS,PUT,DELETE',
                        'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization',
                    ];
       
        $num=1;
       
            $assignedteachername=null;
            $assignedteacherid=null;
        
            $assignedteacherid=$request->assignedteacher;
            //fetching teacher data from teacher microservice
            $client = new \GuzzleHttp\Client();
            
            $r = $client->request('POST', 'http://127.0.0.1:8000/api/generatetoken', [
                'headers'     => ['X-CSRF-Token'=> csrf_token()],
               
           ]);
     
            $token = $r->getBody()->getContents();
            $client = new \GuzzleHttp\Client();
            $body = [
                'assignedteacherid' =>  $assignedteacherid,
                'studentid' =>  $id,
     
            ];
            $r = $client->request('POST', 'http://127.0.0.1:8000/api/getTeacherById', [
                'headers'     => ['X-CSRF-Token'=> csrf_token(),
                                    'Authorization' => 'Bearer ' . $token],
                'form_params' => $body
           ]);
           
           $response = $r->getBody()->getContents();
           $response= json_decode($response);
            $teacherrequests= collect($response->teacher);


            //dd($teacherrequests);
           // $teacherrequests =  DB::select("SELECT * from users where id='$assignedteacherid'");
            foreach ($teacherrequests as $teacherrequests2)
            {
                $assignedteachername= $teacherrequests2->name;
                $assignedteacherid=$teacherrequests2->id;
            }
            //dd($assignedteachername);
        //updating student users in student microservice
        $r = $client->request('POST', 'http://127.0.0.1:8000/api/generatetoken', [
            'headers'     => ['X-CSRF-Token'=> csrf_token()],
           
       ]);
 
        $token = $r->getBody()->getContents();
        $client = new \GuzzleHttp\Client();
        $body = [
            'studentid' =>  $id,
            'assignedteachername' =>$assignedteachername,
 
        ];
        $r = $client->request('POST', 'http://127.0.0.1:8000/api/approveStudent', [
            'headers'     => ['X-CSRF-Token'=> csrf_token(),
                                'Authorization' => 'Bearer ' . $token],
            'form_params' => $body
       ]);
       
       $result = $r->getBody()->getContents();
       $result= json_decode($result);
       //dd($result);
        //$result=DB::update("update users set flag='$num',assignedteacher='$assignedteachername' where id=$id");
        //dd(DB::getQueryLog());
         
        return response($result);

       
        
        
       
        
       
    }


    public function teacherApprove(Request $request, $id)
    {
      
        header("Access-Control-Allow-Origin: *");
        //ALLOW OPTIONS METHOD
        $headers = [
            'Access-Control-Allow-Methods' => 'POST,GET,OPTIONS,PUT,DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization',
        ];
  
          
     //updating teacher users in teacher microservice
     $client = new \GuzzleHttp\Client();
     $r = $client->request('POST', 'http://127.0.0.1:8000/api/generatetoken', [
        'headers'     => ['X-CSRF-Token'=> csrf_token()],
       
   ]);

    $token = $r->getBody()->getContents();
    $client = new \GuzzleHttp\Client();
    $body = [
        'id' =>  $id,
        

    ];
    $r = $client->request('POST', 'http://127.0.0.1:8000/api/approveTeacher', [
        'headers'     => ['X-CSRF-Token'=> csrf_token(),
                            'Authorization' => 'Bearer ' . $token],
        'form_params' => $body
   ]);
   
   $result = $r->getBody()->getContents();
   $result= json_decode($result);
   //dd($result);
    //$result=DB::update("update users set flag='$num',assignedteacher='$assignedteachername' where id=$id");
    //dd(DB::getQueryLog());
     
    return response($result);
        
        
          
        
       
    }
}
