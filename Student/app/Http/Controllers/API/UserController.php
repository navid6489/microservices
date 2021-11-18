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
        $tempuser= $request->user[0];
        $id= $tempuser['id'];
        //$user2= new User;
        $user = User::where('id', $id)->first();
      $token= $user->createToken('MyApp')-> accessToken;
        return response($token);
    }
    public function getData(Request $request)
    {
        $client = new \GuzzleHttp\Client();
       
        $r = $client->request('POST', 'http://127.0.0.1:8002/getData', [
            'headers'     => ['X-CSRF-Token'=> csrf_token(),
                                ],
            
       ]);
 
        $response = $r->getBody()->getContents();
       
        return response($response);
    }
}