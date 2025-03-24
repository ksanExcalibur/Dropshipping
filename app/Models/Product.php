<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'qty', 'description', 'price', 'image','vendor_id', 
    ];

    // Define the comments relationship
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    
    public function averageRating() {
        return $this->comments()->avg('rating'); // Get the average rating
    }
    
}