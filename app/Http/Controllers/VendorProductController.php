<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class VendorProductController extends Controller
{
    public function index()
    {
        $products = Product::where('vendor_id', Auth::id())->get();
        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        return view('vendor.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }

        $data['vendor_id'] = Auth::id(); // Associate product with vendor

        Product::create($data);

        return redirect()->route('vendor.products.index')->with('success', 'Product Created Successfully');
    }

    public function edit(Product $product)
    {
        if ($product->vendor_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        return view('vendor.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->vendor_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('vendor.products.index')->with('success', 'Product Updated Successfully');
    }

    public function destroy(Product $product)
    {
        if ($product->vendor_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $product->delete();
        return redirect()->route('vendor.products.index')->with('success', 'Product Deleted Successfully');
    }
}
