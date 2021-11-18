<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\User;
use DB;
class AdminController extends Controller
{
    /*
    public function redirect(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));
        $query = http_build_query([
            'client_id' => '4',
            'redirect_uri' =>'http://127.0.0.1:8001/callback' ,
            'response_type' => 'code',
            'scope' => '',
        'state' => $state,
        ]);

        return redirect('http://127.0.0.1:8000/oauth/authorize?'.$query);
    }*/

    public function redirect(Request $request)
    {
       // $request->session()->put('state', $state = Str::random(40));
      // $user = User::where('role', 'admin')->get();
        $user= DB::select('select * from users where id = 1');
       $client = new \GuzzleHttp\Client();
       $body = [
           'user' =>  $user,

       ];
       $r = $client->request('POST', 'http://127.0.0.1:8000/api/generatetoken', [
           'headers'     => ['X-CSRF-Token'=> csrf_token()],
           'form_params' => $body
      ]);

       $response = $r->getBody()->getContents();

       

       $query = http_build_query([
        'token'=> $response
    ]);
        return redirect('http://127.0.0.1:8001/callback?'.$query);
    }


    public function callback(Request $request)
    {
        $accessToken =$request->query('token');

        $client = new \GuzzleHttp\Client();
        
        $r = $client->request('POST', 'http://127.0.0.1:8000/api/getData', [
            'headers'     => ['X-CSRF-Token'=> csrf_token(),
                                'Authorization' => 'Bearer ' . $accessToken],
            
       ]);
 
        $response = $r->getBody()->getContents();
        $response= json_decode($response);
        
        $teacher=collect($response->teacher);
        $student=collect(json_decode($response->student));
        $allteacher=collect($response->allteacher);
       //dd($student[1]->name);
       return view('dashboard')->with(compact('teacher','student','allteacher'));
    }
}
