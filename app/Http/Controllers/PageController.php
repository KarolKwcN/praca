<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Role;
use App\Category;
use App\Brand;
use App\Device;
use App\Repair;
use App\Comment;
use DB;

class PageController extends Controller
{
    public function getMarka($slug){
        $category = Category::where('slug', $slug)->first();
    $brand = DB::table('brands')
        ->join('devices', 'brands.id', '=', 'devices.brand_id')
        ->join('repairs', 'devices.id', '=' , 'repairs.device_id')
        ->where('repairs.accept', '=',1)
        ->select('brands.*')
        ->where('category_id', $category->id)
        ->get();
    
        $brands = $brand->unique();

    return view('naprawa.naprawa_marka', compact('brands','category'));
    }

    public function getDevice($slug, $slugi){
        $category = Category::where('slug', $slug)->first();
        $brand = Brand::where('slugi', $slugi)->first();

        $device = DB::table('devices')
        ->join('repairs', 'devices.id', '=', 'repairs.device_id')
        ->where('repairs.accept', '=', 1)
        ->select('devices.*')
        ->where('brand_id', $brand->id)
        ->get();

        $devices= $device->unique();
        return view('naprawa.naprawa_urzadzenie', compact('category','brand', 'devices'));
    }

    public function getRepairs($slug, $slugi,$slugii){
        $category = Category::where('slug', $slug)->first();
        $brand = Brand::where('slugi', $slugi)->first();
        $device = Device::where('slugii', $slugii)->first();

        $repairs = Repair::where('device_id', $device->id)->where('accept', 1)->get();

        return view('naprawa.naprawy', compact('category','brand','device', 'repairs'));

    }

    public function showComments($repair){
          $comments = Comment::with('user', 'repair')->where('repair_id', $repair)->orderBY('created_at','desc')->get();
     
        return $comments;
    }

    public function addComment(Request $request, $repair){
       
       
        $comment = New Comment;
        $comment->repair_id = $repair;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->comment;
      
        $comment->save();
        
    
    }

       public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    }

    public function updateComment(Request $request, $id){

        $comment = Comment::findOrFail($id);

        $comment->comment = $request->comment;
      

        $comment->update();

    }

     public function szukaj(Request $request)
    {
         $this->validate($request, [
            's' => 'required'

        ]);


        $s = $request->input('s');

         $repairs = Repair::with(['devices','devices.brand','devices.brand.category'])->where('name', 'like', '%' .$s. '%')
        ->orWhere('description', 'like', '%' .$s. '%')->get();

        $devices = Device::with(['brand','brand.category'])->where('name', 'like', '%' .$s. '%')
        ->get();

        $brands = Brand::with(['category'])->where('name', 'like', '%' .$s. '%')
        ->get();

        $categories = Category::where('name', 'like', '%' .$s. '%')
        ->get();

            $warunek = array_merge($repairs->toArray(),$devices->toArray(),$brands->toArray(),$categories->toArray());

        

         return view('szukaj', compact('repairs','devices','brands','categories', 'warunek'));

    }

   
}