<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->restrictOnDelete()
                ->constrained();

            $table->foreignId('location_id')
                ->restrictOnDelete()
                ->constrained();

            $table->foreignId('created_by')
                ->restrictOnDelete()
                ->constrained('users');

            $table->string('title');

            $table->text('description')->nullable();

            $table->string('status')
                ->default('draft');

            $table->string('priority')
                ->default('medium');

            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('due_at')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('work_orders');
    }
};
