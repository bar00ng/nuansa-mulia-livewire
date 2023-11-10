<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_detail_vendor', function (Blueprint $table) {
            $table->foreignId('job_detail_id')
                ->onDelete('set null')
                ->constrained();
            $table->foreignId('vendor_id')
                ->onDelete('set null')
                ->constrained();
            $table
                ->foreignId('rab_item_id')
                ->nullable()
                ->default(null)
                ->onDelete('set null')
                ->constrained();
            $table->foreignId('project_id')
                ->onDelete('cascade')
                ->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_detail_vendor');
    }
};
