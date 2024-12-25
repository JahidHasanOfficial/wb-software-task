<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->Paginate(10);
        return view("admin.category.index", compact("categories"));
    }

    public function create()
    {
        // Fetch all existing skills
     
        return view("admin.category.create");
    }

   
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',  
            'slug' => 'required|unique:brands,slug',    
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
       
    
        $category = new Category();
        $category->name = request('name');
        $category->slug = Str::slug(request('name'));
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category', 'public');
            $category->image = $imagePath;
        }
        $category->save();

        return redirect()->route("admin.category-index")->with("success", "Category added successfully!");
    }


   
    public function show($id){
        $categories = Category::findOrFail($id);
        return view("admin.category.show", compact("categories"));
    }


    public function edit($id){
       
        $category = Category::findOrFail($id);
        return view("admin.category.edit", compact("category"));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

      
      

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug(request('name'));
        if ($request->hasFile('image')) {
            $oldLogoPath = $category->image;

            if ($oldLogoPath) {
                $relativePath = str_replace(url('storage/') . '/', '', $oldLogoPath);
                $fullPath = storage_path('app/public/' . $relativePath);

                // Check if the file exists and delete it
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    // Log::info("Old logo deleted: " . $fullPath);
                } else {
                    // Log::error("File not found for deletion: " . $fullPath);
                }
            }

            $imagePath = $request->file('image')->store('CategoryImage', 'public');
            $category->image = $imagePath;
        }
        $category->save();

        return redirect()->route("admin.category-index")->with("success", "Category updated successfully!");

    }


    public function destroy($id){
        $category = Category::findOrFail($id);
        if($category->image){
            $oldLogoPath = $category->image;

            if ($oldLogoPath) {
                $relativePath = str_replace(url('storage/') . '/', '', $oldLogoPath);
                $fullPath = storage_path('app/public/' . $relativePath);

                // Check if the file exists and delete it
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    // Log::info("Old logo deleted: " . $fullPath);
                } else {
                    // Log::error("File not found for deletion: " . $fullPath);
                }
            }
        }
        $category->delete();
        return redirect()->route("admin.category-index")->with("success", "Category deleted successfully!");
    }
    
}