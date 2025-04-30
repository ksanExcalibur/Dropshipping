<?php

namespace Tests\Feature;

use App\Http\Controllers\AuthManager;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthManagerTest extends TestCase
{
    use RefreshDatabase;

    protected AuthManager $authManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authManager = new AuthManager();
    }

    // Test login functionality
    public function testLoginWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    }

    public function testLoginWithInvalidCredentials()
    {
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('error', 'Invalid credentials');
        $this->assertGuest();
    }

    // Test registration functionality
    public function testUserRegistration()
    {
        $response = $this->post('/registration', [
            'fullName' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success', 'User registration successful');
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function testVendorRegistration()
    {
        $response = $this->post('/registration', [
            'fullName' => 'Vendor User',
            'email' => 'vendor@example.com',
            'phone' => '1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'vendor'
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success', 'Vendor registration successful');
        $this->assertDatabaseHas('users', [
            'email' => 'vendor@example.com',
            'role' => 'vendor'
        ]);
    }

    // Test logout functionality
    public function testLogout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $response->assertSessionHas('success', 'Logged out successfully');
        $this->assertGuest();
    }

    // Test password reset functionality
    public function test_password_reset()
    {
        // Create a user
        $user = User::factory()->create();
    
        // Step 1: Request a password reset link
        $response = $this->post(route('password.email'), ['email' => $user->email]);
    
        // Assert the email is sent successfully and session message is correct
        $response->assertSessionHas('status', 'We have emailed your password reset link.');
    
        // Step 2: Generate the plain token using the broker
        $token = app('auth.password.broker')->createToken($user);
    
        // Step 3: Submit the password reset form with the plain token
        $response = $this->post(route('password.update'), [
            'email' => $user->email,
            'token' => $token,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
    
        // Assert the redirect happens to the expected page (login)
        $response->assertRedirect('/login');
    
        // Assert a success message is in the session
        $response->assertSessionHas('success', 'Password reset successfully. Please login with your new password.');
    
        // Step 4: Verify the password was updated
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }
    
    
}
// Dummy change for sequential commit generation 8447684 (Update ProductControllerTest and related test files)
