<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class TestimonialsController extends Controller
{
    public function get_all_testimonial()  {
        $testimonials = Testimonial::orderBy('id' , 'DESC')->get();

        return response()->json([
            'testimonials' => $testimonials
        ], 200);
    }
    public function add_testimonial(Request $request){
        $this->validate($request , [
            'name' => 'required'
        ]);
        $testimonial = new Testimonial();
        $testimonial->name = $request->name;
        $testimonial->function = $request->function;
        $testimonial->testimony = $request->testimony;
        $testimonial->rating = $request->rating;
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
            $name = $testimonial->photo;
        }
        $testimonial->photo = $name;
        $testimonial->save();

    }
    public function get_testimonial($id){
        $testimonial = Testimonial::find($id);
        return response()->json([
            'testimonial' => $testimonial
        ],200);
    }
    public function update_testimonial(Request $request , $id){
        $testimonial = Testimonial::find($id);
        $this->validate($request , [
            'name' => 'required'
        ]);
        $testimonial->name = $request->name;
        $testimonial->function = $request->function;
        $testimonial->testimony = $request->testimony;
        $testimonial->rating = $request->rating;
        if($testimonial->photo != $request->photo) {
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
            $name = $testimonial->photo;
        }
        $testimonial->photo = $name;
        $testimonial->save();
    }
    public function delete_testimonial($id){
        $testimonial = Testimonial::findOrFail($id);
        $img_path = public_path()."/img/upload/";
        $image = $img_path.$testimonial->photo;
        if (file_exists($image)){
            @unlink($image);
        }
        $testimonial->delete();
    }
}
