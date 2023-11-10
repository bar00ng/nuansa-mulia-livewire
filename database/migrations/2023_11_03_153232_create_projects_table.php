<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')
                ->unique();
            $table->string('kd_project')
                ->unique();
            $table->string('nama_project');
            $table->foreignId('client_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('nama_pic');
            $table->string('nomor_pic');
            $table->string('lokasi');
            $table->string('pekerjaan');
            $table->string('status');
            $table->bigInteger('budget_rab')
                ->nullable()
                ->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
