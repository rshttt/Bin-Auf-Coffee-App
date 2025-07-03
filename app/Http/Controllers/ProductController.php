<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->with('reviews')->get();
        
        return response()->json([
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = Category::where('name', strtolower($request->category))->first();

        if(!$category) {
            return redirect('/admin')->with('error', 'Update gagal!');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products,name',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
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
        
        Product::create([
            'name' => $request->name,
            'category_id' => $category->id,
            'stock' => $request->stock,
            'price' => $request->price,
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

        $product = Product::find((int) $id);

        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'product' => $product
        ]);
    }

    public function showUser(string $id) {
        $product = Product::with('category')->with('reviews')->findOrFail($id);
        return view('product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!ctype_digit($id)) {
            abort(400, 'ID tidak valid');
        }

        $product = Product::with('category')->findOrFail((int) $id);
        
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!ctype_digit($id)) {
            abort(400, 'ID tidak valid');
        }

        $category = Category::where('name', strtolower($request->category))->first();
        
        if(!$category) {
            return redirect('/admin')->with('error', 'Update gagal!');
        }

        $product = Product::findOrFail((int) $id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products,name,' . $product->id,
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'remove_image' => 'nullable|in:0,1',
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
            
            if ($product->image_path && file_exists(public_path($product->image_path))) {
                unlink(public_path($product->image_path));
            }

            $image->move($destinationPath, $imageName);
            $imagePath = 'assets/images/' . $imageName;

        } elseif ($request->input('remove_image') == '1') {
            if ($product->image_path && file_exists(public_path($product->image_path))) {
                unlink(public_path($product->image_path));
            }
            $imagePath = null;
        } else {
            $imagePath = $product->image_path;
        }

        $updated = $product->update([
            'name' => $request->name,
            'category_id' => $category->id,
            'stock' => $request->stock,
            'price' => $request->price,
            'image_path' => $imagePath,
            'description' => trim($request->description)
        ]);


        if($updated === 0) {
            return response()->json([
                'message' => 'Produk gagal di-update!',
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
    
        $product = Product::find((int) $id);

        if(!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan!',
            ], 404);
        }
    
        $product->delete();
    
        return redirect('/admin')->with('success', 'Delete berhasil!');
    }
}
