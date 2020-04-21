<?php

namespace App\Http\Controllers\Serwisant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Role;
use App\Category;
use App\Brand;
use App\Device;
use App\Repair;
use DB;

class SerwisantController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')->paginate(10);
    return view('serwisant.serwisant', ['categories' => $categories]);
  
    }

    public function getSerwisantNaprawyMarkaPage($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $brands = Brand::where('category_id', $category->id)->paginate(10);
        return view('serwisant.serwisant_naprawy_marka', compact('brands','category'));
    }

    public function getSerwisantNaprawyModelPage($slug, $slugi)
    {
        $brand = Brand::where('slugi', $slugi)->first();
        $category = Category::where('id',$brand->category_id)->first();
        $devices = Device::where('brand_id', $brand->id)->paginate(10);
        return view('serwisant.serwisant_naprawy_model', compact('devices','brand','category'));
    }

    public function getSerwisantUrzadzenie($slug,$slugi,$slugii)
    {

        $device = Device::where('slugii', $slugii)->first();
        $brand = Brand::where('id',$device->brand_id)->first();
        $category = Category::where('id', $brand->category_id)->first();

    
        return view('serwisant.serwisant_urzadzenie', compact('device','brand','category'));
    }

    public function addRepair(Request $request, $id)
    {
     
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $repair = New Repair;
        $repair->name = $request->name;
        $repair->description = $request->description;
        $repair->slugi_repair = str_slug($request->name);
        $repair->device_id = $id;
        $repair->user_id = Auth::user()->id;
        $repair->status = 0;
        $repair->accept = 0;
        $repair->image =  $imageName;
        $repair->save();

    return ['message' => 'Model dodany'];
    }
}
