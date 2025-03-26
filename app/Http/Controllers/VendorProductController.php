<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class VendorProductController extends Controller
{
    public function index()
    {
        $products = Product::where('vendor_id', Auth::id())->with('category')->get();
        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('vendor.products.create', compact('categories'));
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
