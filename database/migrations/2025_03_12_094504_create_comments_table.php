<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who made the comment
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Product being commented on
            $table->text('comment');
            $table->integer('rating')->nullable(); // Optional: If you want to include reviews with ratings
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('comments');
    }
};
