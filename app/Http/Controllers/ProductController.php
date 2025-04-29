<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create(){
        return view('admin.products.create');
    }

    public function userindex()
    {
        $search = request('search');
        $categoryId = request('category');
        $query = Product::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        $products = $query->get();
        $categories = \App\Models\Category::all();
        return view('userpage.shop', compact('products', 'categories'));
    }


    
    public function commentindex() {
        $topRatedProducts = Product::with('comments')
            ->whereHas('comments', function ($query) {
                $query->whereNotNull('rating'); // Ensure products have ratings
            })
            ->get()
            ->sortByDesc(function ($product) {
                return $product->averageRating();
            })
            ->take(5); // Get top 5 rated products
    
        return view('userpage.home', compact('topRatedProducts'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.product-details', compact('product'));
    }

    public function showDetails($id)
    {
        $product = Product::with('comments.user')->findOrFail($id);
        return view('backend.product-details', compact('product'));
    }

    public function store(Request $request){
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

        Product::create($data);
        
        return redirect(route('admin.products.index'))->with('success', 'Product Created Successfully');
    }

    public function edit(Product $product){
        return view('admin.products.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product){
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
        return redirect(route('admin.products.index'))->with('success', 'Product Updated Successfully');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect(route('admin.products.index'))->with('success', 'Product Deleted Successfully');
    }

    public function home()
    {
        $products = Product::all();
        
        $topRatedProducts = Product::with(['comments' => function($query) {
                $query->whereNotNull('rating');
            }])
            ->withAvg('comments as average_rating', 'rating')
            ->having('average_rating', '>=', 4)
            ->orderByDesc('average_rating')
            ->take(5)
            ->get();
    
        return view('userpage.home', compact('products', 'topRatedProducts'));
    }

    // Add to Cart
    public function addToCart(Request $request, $id)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to add products to your cart.');
    }

    $product = Product::findOrFail($id);

    $cart = Cart::updateOrCreate(
        ['user_id' => Auth::id(), 'product_id' => $product->id],
        ['quantity' => \DB::raw('quantity + 1')]
    );

    return redirect()->back()->with('success', 'Product added to cart successfully');
}

    // View Cart
    public function viewCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('backend.cart', compact('cartItems'));
    }
// Remove from Cart
public function removeFromCart($id)
{
    $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();
    if ($cartItem) {
        $cartItem->delete();
        return redirect()->back()->with('success', 'Product removed from cart successfully');
    }
    return redirect()->back()->with('error', 'Product not found in cart');
}
    
}