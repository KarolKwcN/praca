<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Category;
use App\Brand;
use App\Device;
use App\Repair;
use DB;

class AdminController extends Controller
{
    public function getAdminPage()
    {
    	//$users = User::all()->paginate(10);
    	return view('admin.admin');
    }

    public function viewUser()
    {
       $user = User::with('roles')->paginate(5);
      /* $user = DB::table('users')->select('users.id','users.name','users.email','user_role.role_id')->
       join('user_role','user_role.user_id','=','users.id')->get();*/
    	return $user;
    	
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        //usuwanie roli usunietego uzytkownika
        DB::table('user_role')->where('user_id', '=', $id)->delete();
    
        return ['message' => 'User Deleted'];
    }

    public function addSerwisant($id)
    {
        $user = User::findOrFail($id);

        $user->roles()->attach(Role::where('name', 'Serwisant')->first());

        return ['message' => 'Rola serwisant dodana.'];
    }

    public function addAdmin($id)
    {
        $user = User::findOrFail($id);

        $user->roles()->attach(Role::where('name', 'Admin')->first());

        return ['message' => 'Rola admin dodana.'];
    }

    public function deleteAdmin($id)
    {
        $user = User::findOrFail($id);

        $user->roles()->detach(Role::where('name', 'Admin')->first());

        return ['message' => 'Rola admin usunięta.'];
    }

    public function deleteSerwisant($id)
    {
        $user = User::findOrFail($id);

        $user->roles()->detach(Role::where('name', 'Serwisant')->first());

        return ['message' => 'Rola serwisant usunięta.'];
    }

    public function addBan($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        //dodawanie 14 dni bana
         $timestamp = strtotime("+14 Days");
         $datum = date("Y-m-d H:i:s",$timestamp);

         $user->banned_until=$datum;
         $user->save();

         return ['message' => 'Użytkownik zbanowany'];

    }

    public function deleteBan($id)
    {

        $user = User::where('id', $id)->firstOrFail();
        //dodawanie 14 dni bana
        
        $user->banned_until=null;
        $user->save();

    }

    public function getAdminRepairPage()
    {
        return view('admin.naprawy');
    }

    public function addCategory(Request $request)
    {
      
        $imageName = rand().time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images/kategorie/'), $imageName);
        $category = New Category;
        $category->name = $request->name;
        $category->slug = str_slug($request->name);
        $category->image = "/images/kategorie/$imageName";
        $category->save();

    }

    public function showCategory()
    {
        
        $categories = Category::paginate(5);
        return $categories;
    }


    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        //usuwanie roli usunietego uzytkownika
    
    
        return ['message' => 'Category Deleted'];
    }

    public function updateCategory(Request $request, $id)
    {
        
        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->slug = str_slug($request->name);

        $image = $request->file('image');

          if(isset($image)){
            $imageName = rand().time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/kategorie/'), $imageName);
            $category->image = "/images/kategorie/$imageName";
        }

        $category->update();
        

        

       

    }

    public function getAdminNaprawyMarkaPage($slug)
    {
        $category = Category::where('slug', $slug)->first();
   
    return view('admin.marka', compact('category'));
    }

    public function showBrands($id)
    {
       
        $brands = Brand::where('category_id', $id)->paginate(5);
        return $brands;
        
    }

    public function deleteBrand($id)
    {
        $brand = Brand::findOrFail($id);

        $brand->delete();

        //usuwanie roli usunietego uzytkownika
    
    
        return ['message' => 'Brand Deleted'];
    }

    public function updateBrand(Request $request, $id)
    {

           $brand = Brand::findOrFail($id);

        $brand->name = $request->name;
        $brand->slugi = str_slug($request->name);
        $brand->description = $request->description;

        $image = $request->file('image');

          if(isset($image)){
            $imageName = rand().time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/marka/'), $imageName);
            $brand->image = "/images/marka/$imageName";
        }

        $brand->update();
    }

    public function addBrand(Request $request, $id)
    {
        $imageName = rand().time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images/marka/'), $imageName);
        $brand = New Brand;
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->slugi = str_slug($request->name);
        $brand->image = "/images/marka/$imageName";
        $brand->category_id = $id;
        $brand->save();

    }

    public function categoryName($id)
    {
        $category = Category::where('id', $id)->firstOrFail();
        return $category;
        
    }

    public function getAdminNaprawyDevicePage($slug,$slugi)
    {
        $brand = Brand::where('slugi', $slugi)->firstOrFail();
        $category = Category::where('id',$brand->category_id)->firstOrFail();
   
    return view('admin.device', compact('brand','category'));
    }

    public function showDevices($id)
    {
       
        $devices = Device::with('brand', 'brand.category')->where('brand_id', $id)->paginate(5);
        return $devices;
     
        
        
    }

    public function deleteDevice($id)
    {
        $device = Device::findOrFail($id);

        $device->delete();

        //usuwanie roli usunietego uzytkownika
    
    
        return ['message' => 'device Deleted'];
    }

    public function updateDevice(Request $request, $id)
    {

            $device = Device::findOrFail($id);

        $device->name = $request->name;
        $device->slugii = str_slug($request->name);
        $device->description = $request->description;

        $image = $request->file('image');

          if(isset($image)){
            $imageName = rand().time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/urzadzenie/'), $imageName);
            $device->image = "/images/urzadzenie/$imageName";
        }

        $device->update();
    }

    public function addDevice(Request $request, $id)
    {
        $imageName = rand().time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images/urzadzenie/'), $imageName);
        $device = New Device;
        $device->name = $request->name;
        $device->description = $request->description;
        $device->slugii = str_slug($request->name);
        $device->image = "/images/urzadzenie/$imageName";
        $device->brand_id = $id;
        $device->save();
    }

    public function getAdminRepiarsDevice($slug,$slugi,$slugii){

        $device = Device::where('slugii', $slugii)->firstOrFail();
        $brand = Brand::where('slugi', $slugi)->firstOrFail();
        $category = Category::where('slug',$slug)->firstOrFail();
   
    return view('admin.adminDeviceRepair', compact('brand','category','device'));
    }

    public function showDeviceRepairs($id)
    {
        $repairs = Repair::with('users', 'devices', 'devices.brand', 'devices.brand.category')->where('device_id', $id)->get();
        return $repairs;
    }

    public function akceptujnaprawe(Request $request, $id)
    {
        $repair = Repair::findOrFail($id);
            $repair->accept = 1;
            $repair->update();
    }
    
    public function odrzucnaprawe($id)
    {
        $repair = Repair::findOrFail($id);
        $repair->accept = 0;
        $repair->update();
    }

    public function przekazdorealziacji($id)
    {
        $repair = Repair::findOrFail($id);
        $repair->status = 0;
        $repair->update();
    }

    public function deleteRepair($id)
    {
        $repair = Repair::findOrFail($id);
        $repair->steps()->delete();
        $repair->delete();
    }
}
