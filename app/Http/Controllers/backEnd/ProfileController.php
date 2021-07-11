<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function profileView(){
        $user = User::find(Auth::id());
        return view("backend.user.viewProfile",compact("user"));
    }

    public function editeProfile(){
        $edite = User::find(Auth::id());
        return view("backend.user.editeProfile",compact("edite"));
    }

    public function storeProfile(Request $request){

        $user = User::find(Auth::id());
        $user->name=$request->name;
        $user->email=$request->email;
        $user->mobile=$request->mobile;
        $user->address=$request->address;
        $user->gender=$request->gender;
            if($request->file("image")){
                $file = $request->file("image");
                @unlink(public_path("upload/userImages".$user->image));
                $fileName = date("YmdHi").$file->getClientOriginalExtension();
                $file->move(public_path("upload/userImages"),$fileName);
                $user->image = $fileName;
            }
        $user->save();
        $notification = array(
            'message' => 'User Profile Update successfully',
            'alert_type'=>"success"
        );
        return Redirect()->route("profileView")->with($notification);
    }

    public function changePassword(){
        return view("backend.user.changePassword");
    }

    public function updatePassword(Request $request){

        $validatedData = $request->validate([
            "oldPassword"=>"required",
            "password"=>"required|confirmed",
        ]);

        $hashedPassword = Auth::user()->password;

        if(hash::check($request->oldPassword,$hashedPassword)){
            $user = User::find(Auth::id());

            $user->password = hash::make($request->password);
            $user->save();
            Auth::logout();
            return Redirect()->route("login");
        }
        else
            return Redirect()->back();

    }

}
