<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Category;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_products()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $product = Product::factory()->create();
        $response = $this->get(route('admin.products.index'));
        $response->assertStatus(200);
        $response->assertViewHas('products');
    }

    public function test_create_displays_create_form()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $response = $this->get(route('admin.products.create'));
        $response->assertStatus(200);
    }

    public function test_store_creates_product()
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $data = [
            'name' => 'Test Product',
            'qty' => 10,
            'description' => 'Test Description',
            'price' => 99.99,
            'image' => UploadedFile::fake()->image('product.jpg'),
        ];
        $response = $this->post(route('admin.products.store'), $data);
        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_edit_displays_edit_form()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $product = Product::factory()->create();
        $response = $this->get(route('admin.products.edit', $product));
        $response->assertStatus(200);
        $response->assertViewHas('product');
    }

    public function test_update_updates_product()
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $product = Product::factory()->create();
        $data = [
            'name' => 'Updated Name',
            'qty' => 5,
            'description' => 'Updated Description',
            'price' => 49.99,
            'image' => UploadedFile::fake()->image('updated.jpg'),
        ];
        $response = $this->put(route('admin.products.update', $product), $data);
        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Updated Name']);
    }

    public function test_destroy_deletes_product()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $product = Product::factory()->create();
        $response = $this->delete(route('admin.products.destroy', $product));
        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_userindex_filters_products_by_search_and_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['name' => 'SpecialName', 'category_id' => $category->id]);
        $response = $this->get(route('shop', ['search' => 'SpecialName', 'category' => $category->id]));
        $response->assertStatus(200);
        $response->assertViewHas('products');
    }

    public function test_add_to_cart_requires_authentication()
    {
        $product = Product::factory()->create();
        $response = $this->post(route('cart.add', $product->id));
        $response->assertRedirect(route('login'));
    }

    public function test_add_to_cart_adds_product_for_authenticated_user()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('cart.add', $product->id));
        $response->assertRedirect();
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);
    }

    public function test_view_cart_displays_cart_items()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        Cart::create(['user_id' => $user->id, 'product_id' => $product->id, 'quantity' => 1]);
        $this->actingAs($user);
        $response = $this->get(route('cart.view'));
        $response->assertStatus(200);
        $response->assertViewHas('cartItems');
    }

    public function test_remove_from_cart_deletes_cart_item()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $cart = Cart::create(['user_id' => $user->id, 'product_id' => $product->id, 'quantity' => 1]);
        $this->actingAs($user);
        $response = $this->delete(route('cart.remove', $cart->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }
}