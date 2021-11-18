<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Providers\StudentAssigned;
use App\Providers\AccountApproved;
class TeacherController extends Controller
{
    public function getData(Request $request)
    {
        $user = User::where('flag', '1')->get();
        $user2 = User::where('flag', '0')->get();
        return response(['allteacher'=>$user,'teacher'=>$user2]);
    }
    public function getTeacherById(Request $request)
    {
        $id= $request->assignedteacherid;
        $studentid=$request->studentid;
        $teacher = User::where('id', $id)->get();
       
        event(new StudentAssigned($studentid,$teacher[0]->name,$teacher[0]->id));
        return response(['teacher'=>$teacher]);
    }

    public function approveTeacher(Request $request)
    {
        $id= $request->id;
       
       
        $result = User::where('id', '=', $id)->update(array('flag'=>'1'));
        //student approved event
        event(new AccountApproved($id));
        return response($result);
    }
}
