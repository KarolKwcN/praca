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
use App\Step;
use App\ImageStep;
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
        

        
         $messages = [              
                    "name.required" => 'Nazwa naprawy jest wymagana',
                    "description.required" => 'Opis jest wymagany',
                    
                    "image.max" => "Zdjęcie może mieć maksymalnie 1 mb",
                    "image.mimes" => "Zdjęcie może mieć tylko rozszerzenie: jpeg, png, jpg, giv, svg",
                    "image.image" => "Zdjęcie musi być obrazkiem",
                    "image.required" => 'Zdjęcie jest wymagane',
                ];

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1000',

        ] ,$messages
                );

      
        
        

        $imageName = rand().time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images/'.$id), $imageName);
        $repair = New Repair;
        $repair->name = $request->name;
        $repair->description = $request->description;
        $repair->slugi_repair = str_slug($request->name);
        $repair->device_id = $id;
        $repair->user_id = Auth::user()->id;
        $repair->status = 0;
        $repair->accept = 0;
        $repair->image = "/images/$id/$imageName";
        $repair->save();

    return ['message' => 'Model dodany'];
    }

    public function showRepairs($id)
    {
       
        //$user_id = Auth::user()->id;
        $repairs = Repair::with('users')->where('device_id', $id)->get();
     
        return $repairs;
      
    }

    public function getSerwisantNaprawa($device, $id)
    {
        $user_id = Auth::user()->id;
        $device = Device::where('id', $device)->first();
        $repair = Repair::where('id' ,$id)->first();

        if ($user_id === $repair->user_id) {
            return view('serwisant.serwisant_naprawa', compact('device','repair'));
        }
        
        return view('brak_uprawnien');
    }

    public function addStepRepair(Request $request,$repair)
    {
                 $messages = [
                    "pics.max" => "Maksymalnie mogą być 3 zdjęcia.",
                    "pics.required" => "Zdjęcia są wymagane",
                    "pics.*.max" => "Zdjęcie może mieć maksymalnie 1 mb",
                    "pics.*.mimes" => "Zdjęcie może mieć tylko rozszerzenie: jpeg, png, jpg, giv, svg",
                    "pics.*.image" => "Zdjęcie musi być obrazkiem",
                    "name.required" => 'Nazwa kroku jest wymagana',
                    "description.required" => "Opis jest wymagany"
                ];
                
          $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
              'pics.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
              'pics' => 'required|max:3'
        ]
        ,$messages
                );



        $naprawa = Repair::find($repair);
        $device_id=$naprawa->device_id;
        $name_repair=$naprawa->name;

        $id_naprawy=$naprawa->id;

        
        
        $uploadedFiles=$request->pics;

        
         $step = New Step;
         $step->name = $request->name;
         $step->description = $request->description;
         $step->repair_id = $repair;
         $step->save();

         $laststepid = $step->id;



    foreach ($uploadedFiles as $file){
        
       
        $imageName = rand() . time() . '.' .  $file->getClientOriginalExtension();
        $file->move(public_path('images/'.$device_id.'/'.$id_naprawy), $imageName);
        
        $imagestep = New ImageStep;
        $imagestep->image = "/images/$device_id/$id_naprawy/$imageName";
        $imagestep->step_id =  $laststepid;
        $imagestep->save();
        
    }
 
    }

    public function showSteps($repair)
    {
       
        $steps = Step::with('imagesteps', 'repairs')->where('repair_id', $repair)->get();
     
        return $steps;
    }

    public function updatestep(Request $request, $id )
    {

        $messages = [
                    "picsss.max" => "Maksymalnie mogą być 3 zdjęcia.",
                    "picsss.required" => "Zdjęcia są wymagane",
                    "name.required" => 'Nazwa kroku jest wymagana',
                    "description.required" => "Opis jest wymagany",
                    "pics.*.max" => "Zdjęcie może mieć maksymalnie 1 mb",
                    "pics.*.mimes" => "Zdjęcie może mieć tylko rozszerzenie: jpeg, png, jpg, giv, svg",
                    "pics.*.image" => "Zdjęcie musi być obrazkiem",
                ];
            
          $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
              'picsss' => 'required|numeric|max:3',
              'pics.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]
        ,$messages
                );

                


        $step = Step::findOrFail($id);
        $step->name = $request->name;
        $step->description = $request->description;
        $step->update();

        $repair_id = $step->repair_id;

        $repair = Repair::findOrFail($repair_id);

        $repair_name = $repair->name;
        $device_id = $repair->device_id;



       ImageStep::where('step_id', $id )->get()->each->delete();
        

        $uploadedFiles=$request->pics;
        $uploadedFiless=$request->picss;
       
        if(isset($uploadedFiless))
        {
        foreach ($uploadedFiless as $file){

            $imagestep = New ImageStep;
            $imagestep->image = $file;
            $imagestep->step_id =  $id;
            $imagestep->save();
            
        }
    }


        if(isset($uploadedFiles)){
        foreach ($uploadedFiles as $file){
        
       
            $imageName = rand() . time() . '.' .  $file->getClientOriginalExtension();
            $file->move(public_path('images/'.$device_id.'/'.$repair_id), $imageName);
            
            $imagestep = New ImageStep;
            $imagestep->image = "/images/$device_id/$repair_id/$imageName";
            $imagestep->step_id =  $id;
            $imagestep->save();
            
        }
    }
    }

    public function deleteStep($id)
    {
        $step = Step::findOrFail($id);

        ImageStep::where("step_id", $step->id)->delete();
        $step->delete();
    }

    public function showRepair($id)
    {
        $repair = Repair::where('id', $id)->get();
        return $repair;

    }

    public function editRepair(Request $request, $id)
    {

            $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $repair = Repair::findOrFail($id);
        $repair->name = $request->name;
        $repair->description = $request->description;
        $repair->slugi_repair = str_slug($request->name);


        $image = $request->image;
       

        if(isset($image)){
            $imageName = rand().time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/'.$id), $imageName);
            $repair->image = "/images/$id/$imageName";
        }


        $repair->update();
        $image = $request->image;

        return $image;
    }

    public function endRepair($id){
        $repair = Repair::findOrFail($id);

        $repair->status = 1;

        $repair->update();
    }
}
