<?php

namespace App\Http\Controllers\backEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function UserView(){
                                                //One ways
//        $allData = User::all();
//        return view("backend.user.viewUser",compact("allData"));
        $data["allData"] = User::all();
        return view("backend.user.viewUser",$data);
    }

    public function UserAdd(){
        return view("backend.user.addUser");
    }

    public function UserStore(Request $request){

    $validatedData = $request->validate([
        "email"=>"required|unique:users",
        "name"=>"required",

    ]);

        User::insert([
            "userType"=>$request->userType,
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>bcrypt($request->password),
        ]);
        $notification = array(
            'message' => 'User inserted successfully',
            'alert_type'=>"success"
        );
        return Redirect()->route("UserView")->with($notification);
    }

    public function UserEdite($id){
        $data = User::find($id);
        return view("backend.user.edite",compact("data"));
    }

    public function UserUpdate(Request $request,$id){
//        dd($request->userType,$request->name,$request->email);
//        User::find($id)->update([
//            "userType"=>$request->userType,
//            "name"=>$request->name,
//            "email"=>$request->email,
//        ]);
        $data = User::find($id);
        $data->userType = $request->userType;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->save();


        $notification = array(
            'message' => 'User Update successfully',
            'alert_type'=>"success"
        );
        return Redirect()->route("UserView")->with($notification);
    }

    public function UserDelete($id){

        User::find($id)->delete();
        $notification = array(
            'message' => 'User Deleted successfully',
            'alert_type'=>"success"
        );
        return Redirect()->route("UserView")->with($notification);



    }

}
