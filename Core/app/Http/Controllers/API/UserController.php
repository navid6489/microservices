<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
class UserController extends Controller 
{
    public function generatetoken(Request $request)
    {
       
        $id= 1;
        //$user2= new User;
        $user = User::where('id', $id)->first();
      $token= $user->createToken('MyApp')-> accessToken;
        return response($token);
    }
    public function getData(Request $request)
    {
        $client = new \GuzzleHttp\Client();
       
        $r = $client->request('POST', 'http://127.0.0.1:8002/api/getData', [
            'headers'     => ['X-CSRF-Token'=> csrf_token(),
                                ],
            
       ]);
 
        $student = $r->getBody()->getContents();
        $client = new \GuzzleHttp\Client();
       
        $r = $client->request('POST', 'http://127.0.0.1:8003/api/getData', [
            'headers'     => ['X-CSRF-Token'=> csrf_token(),
                                ],
            
       ]);
 
        $response = $r->getBody()->getContents();
        $response= json_decode($response);
       $teacher=$response->teacher;
       $allteacher=$response->allteacher;
        return response()->json(['student'=>$student,'teacher'=>$teacher,'allteacher'=>$allteacher]);
        
    }

    public function getTeacherById(Request $request)
    {
        $id= $request->assignedteacherid;
        $studentid=$request->studentid;
        //dd($id);
        $client = new \GuzzleHttp\Client();
        $body = [
            'assignedteacherid' =>  $id,
            'studentid' =>  $studentid,
 
        ];
        $r = $client->request('POST', 'http://127.0.0.1:8003/api/getTeacherById', [
            'headers'     => ['X-CSRF-Token'=> csrf_token(),
                                ],
            'form_params' => $body,
       ]);
 
        $teacher = $r->getBody()->getContents();
       
        return response($teacher);
        
    }

    public function approveStudent(Request $request)
    {
        $id= $request->studentid;
        $assignedteachername=$request->assignedteachername;
        //dd($id);
        $client = new \GuzzleHttp\Client();
        $body = [
            'studentid' =>  $id,
            'assignedteachername' =>$assignedteachername,
 
        ];
        $r = $client->request('POST', 'http://127.0.0.1:8002/api/approveStudent', [
            'headers'     => ['X-CSRF-Token'=> csrf_token(),
                                ],
            'form_params' => $body,
       ]);
 
        $result = $r->getBody()->getContents();
       
        return response($result);
        
    }


    public function approveTeacher(Request $request)
    {
        $id= $request->id;
       
        $client = new \GuzzleHttp\Client();
        $body = [
            'id' =>  $id,
            
 
        ];
        $r = $client->request('POST', 'http://127.0.0.1:8003/api/approveTeacher', [
            'headers'     => ['X-CSRF-Token'=> csrf_token(),
                                ],
            'form_params' => $body,
       ]);
 
        $result = $r->getBody()->getContents();
       
        return response($result);
        
    }

}