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
        Schema::create('rab_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subtotal_material');
            $table->bigInteger('subtotal_ongkos_kerja')
                ->nullable()
                ->default(0);
            $table->bigInteger('total_biaya');
            $table->double('lain_lain', 8, 2)
                ->nullable()
                ->default(0);
            $table->double('jasa_kontraktor', 8, 2)
                ->nullable()
                ->default(0);
            $table->bigInteger('grand_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rab_items');
    }
};
