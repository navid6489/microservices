<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Providers\AccountApproved;
class StudentController extends Controller
{
    public function getData(Request $request)
    {
        $user = User::where('flag', '0')->get();
        return response($user);
    }
    public function approveStudent(Request $request)
    {
        $id= $request->studentid;
        $assignedteachername=$request->assignedteachername;
       
        $result = User::where('id', '=', $id)->update(array('assignedteacher' => $assignedteachername,'flag'=>'1'));
        //student approved event
        event(new AccountApproved($id));
        return response($result);
    }
}
