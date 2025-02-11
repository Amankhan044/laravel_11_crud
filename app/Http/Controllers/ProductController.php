<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Products;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::orderBy('created_at', 'DESC')->paginate(2);
        return view('products.list', ['products' => $products]);
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
        $product = new Products();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku,'.$product->id,
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('products.create')->withErrors($validator)->withInput();
        }

        // ✅ Create new product
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        
        // ✅ Generate Unique Slug
        $product->slug = Str::slug($request->name) . '-' . time();

        // ✅ Handle Image Upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->file('image')->move(public_path('upload/products'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $product = Products::where('slug', $slug)->firstOrFail();
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $product = Products::where('slug', $slug)->firstOrFail();
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('products.edit', $product->slug)->withErrors($validator)->withInput();
        }
    
        // ✅ Update product
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
    
        // ✅ Handle Image Upload
        if ($request->hasFile('image')) {
            File::delete(public_path('upload/products/' . $product->image));
            $imageName = time() . '.' . $request->image->extension();
            $request->file('image')->move(public_path('upload/products'), $imageName);
            $product->image = $imageName;
        }
    
        $product->save();
    
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
{
    $product = Products::where('slug', $slug)->firstOrFail();
    File::delete(public_path('upload/products/' . $product->image));
    $product->delete();
    return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
}
}
