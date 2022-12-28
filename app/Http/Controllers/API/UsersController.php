<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UsersController extends Controller
{
    public function get_all_user(){
        $users = User::all();
        return response()->json([
            'users' => $users
        ],200);
    }
    public function create_user(Request $request){
        $this->validate($request,[
            'name' => 'required|min:2|max:50',
            'email' => 'required|email',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->type = $request->type;
        $user->bio = $request->bio;
        if($request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(500, 700);
            $upload_path = public_path() . "/img/upload/";
            $image = $upload_path . $request->photo;
            $img->save($upload_path . $name);
            if (file_exists($image)) {
                @unlink($image);
            }
        }   else {
            $name = "avatar.png";
        }
        $user->photo = $name;
        $user->save();
    }
    public function update_user(Request $request , $id){
        $this->validate($request,[
            'name' => 'required|min:2|max:50',
            'email' => 'required|email',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->type = $request->type;
        $user->bio = $request->bio;
        if($user->photo != $request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(500, 700);
            $upload_path = public_path() . "/img/upload/";
            $image = $upload_path . $request->photo;
            $img->save($upload_path . $name);
            if (file_exists($image)) {
                @unlink($image);
            }
        }   else {
            $name = "avatar.png";
        }
        $user->photo = $name;
        $user->save();
    }
    public function delete_user($id){
        $user = User::findOrFail($id);
        $image_path = public_path()."/img/upload/";
        $image = $image_path.$user->photo;
        if (file_exists($image)){
            @unlink($image);
        }
        $user->delete();
    }
    public function profile(){
        return Auth::user();
    }
    public function update_profile(Request $request , $id){

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password == 'undefined'){
            $user->password = $request->password;
        } else {
            $user->password = Hash::make($request->password);
        }
        $user->bio = $request->bio;
        if($user->photo != $request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(500, 700);
            $upload_path = public_path() . "/img/upload/";
            $image = $upload_path . $request->photo;
            $img->save($upload_path . $name);
            if (file_exists($image)) {
                @unlink($image);
            }
        }   else {
            $name = "avatar.png";
        }
        $user->photo = $name;
        $user->save();
    }
    public function user(){
        if (Auth::check()){
            $user = Auth::user();
            return response()->json([
                'user' => $user
            ],200);
        }
    }
}
