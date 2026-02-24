<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['contact_request', 'support_request', 'demo_request'])->default('contact_request');
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->string('product_interest')->nullable();
            $table->unsignedInteger('branch_count')->nullable();
            $table->string('preferred_contact_time')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->string('source_page')->nullable();
            $table->enum('status', ['new', 'in_progress', 'closed'])->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
