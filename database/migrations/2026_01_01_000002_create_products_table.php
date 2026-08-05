<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('brand')->nullable();
            $table->string('serial_number')->nullable()->index();
            $table->string('location')->nullable()->index();
            $table->integer('stock')->default(0);
            $table->string('unit')->default('pcs');
            $table->text('description')->nullable();
            $table->text('specifications')->nullable();
            $table->enum('status', ['active', 'damaged', 'borrowed', 'out_of_stock', 'discontinued'])->default('active')->index();
            $table->date('entry_date')->nullable();
            $table->string('image')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
