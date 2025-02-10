<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Products;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::orderBy('created_at', 'DESC')->paginate(1);
        return view('products.list',['products' => $products]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('products.create')->withErrors($validator)->withInput();
        }
    
        // ✅ Create new product
        $product = new Products();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
    
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product=Products::findorFail($id);
        return view('products.edit',['product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    
    {
        $product=Products::findorFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('products.edit',$product->id)->withErrors($validator)->withInput();
        }
    
        // ✅ Create new product
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
    
        return redirect()->route('products.index',)->with('success', 'Product Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Products::findorFail($id);
        File::delete(public_path('upload/products/' . $product->image));
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');

    }
}
