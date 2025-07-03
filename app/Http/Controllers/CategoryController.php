<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        
        return response()->json([
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('assets/images');

            $image->move($destinationPath, $imageName);
            $imagePath = 'assets/images/' . $imageName;

        } else {
            $imagePath = null;
        }

        Category::create([
            'name' => $request->name,
            'image_path' => $imagePath,
            'description' => trim($request->description)
        ]);

        return redirect('/admin')->with('success', 'Create berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!ctype_digit($id)) {
            abort(400, 'ID tidak valid');
        }

        $category = Category::find((int) $id);

        if (!$category) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!ctype_digit($id)) {
            abort(400, 'ID tidak valid');
        }

        $category = Category::findOrFail((int) $id);
        
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!ctype_digit($id)) {
            abort(400, 'ID tidak valid');
        }

        $category = Category::findOrFail((int) $id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,' . $category->id,
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('assets/images');
            
            if ($category->image_path && file_exists(public_path($category->image_path))) {
                unlink(public_path($category->image_path));
            }

            $image->move($destinationPath, $imageName);
            $imagePath = 'assets/images/' . $imageName;

        } elseif ($request->input('remove_image') == '1') {
            if ($category->image_path && file_exists(public_path($category->image_path))) {
                unlink(public_path($category->image_path));
            }
            $imagePath = null;
        } else {
            $imagePath = $category->image_path;
        }

        $updated = Category::where('id', (int) $id)->update([
            'name' => $request->name,
            'image_path' => $imagePath,
            'description' => trim($request->description)
        ]);

        if($updated === 0) {
            return response()->json([
                'message' => 'Kategori gagal di-update!',
            ], 400);
        }

        return redirect('/admin')->with('success', 'Update berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!ctype_digit($id)) {
            return response()->json([
                'message' => 'Invalid id!',
            ], 400);
        }
    
        $category = Category::find((int) $id);

        if (!$category) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan!',
            ], 404);
        }
    
        $category->delete();
    
        return redirect('/admin')->with('success', 'Delete berhasil!');
    }
}
