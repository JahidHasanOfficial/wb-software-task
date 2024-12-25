<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
      return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validation = Validator::make(request()->all(), [
            'name' => 'required',  
            'slug' => 'required|unique:brands,slug',    
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }
        $brand = new Brand();
        $brand->name = request('name');
        $brand->slug = Str::slug(request('name'));
        $brand->image = request('image');
        // $image = $request->file('image');
        // $file_extension = $request->file('image')->extension();
        // $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        // $this->GenerateBrandThumbnailImage($image, $file_name);
        // $brand->image = $file_name;
        // $brand->save();
        // }
        // public function GenerateBrandThumbnailImage($image, $imageName){
        //     $destinationPath = public_path('uploads/brands');
        //     $img = Image::make($image->Path());
        //     $img->cover(124, 124, function ($constraints) {
        //         $constraints->aspectRatio();
        //     })->save($destinationPath.'/'.$imageName);
        
        // }

        $image = request()->file('image');
        if ($image) {
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/brand'), $imageName);
            $brand->image = $imageName;
        }
        $brand->save();
        return redirect()->route('admin-brands.index')->with('success', 'Brand created successfully');
   }

   public function edit($id){
    $brand = Brand::find($id);
    return view('admin.brands.edit', compact('brand'));
   }
   public function update(Request $request, $id){
    $brand = Brand::find($id);
    $brand->name = request('name');
    $brand->slug = Str::slug(request('name'));

//old image unlick and delete and new image upload
$image = request()->file('image');
if ($image) {
    // Check if there's an old image and delete it
    if ($brand->image && file_exists(public_path('images/brand/'.$brand->image))) {
        unlink(public_path('images/brand/'.$brand->image));
    }

    // Upload the new image
    $imageName = time().'.'.$image->getClientOriginalExtension();
    $image->move(public_path('images/brand'), $imageName);
    $brand->image = $imageName;
}


  
    $brand->save();
    return redirect()->route('admin-brands.index')->with('success', 'Brand updated successfully');
   }

   public function destroy($id)
   {
       $brand = Brand::find($id);
   
       if ($brand) {
           // Check if the brand has an image and delete it
           if ($brand->image && file_exists(public_path('images/brand/'.$brand->image))) {
               unlink(public_path('images/brand/'.$brand->image));
           }
   
           // Delete the brand record
           $brand->delete();
   
           return redirect()->route('admin-brands.index')->with('success', 'Brand deleted successfully');
       }
   
       return redirect()->route('admin-brands.index')->with('error', 'Brand not found');
   }
   
   
}
