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
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();

            // ATASAN
            $table->float('panjang')->nullable();
            $table->float('lingkar_badan')->nullable();
            $table->float('lingkar_pinggang')->nullable();
            $table->float('punggung')->nullable();
            $table->float('panjang_lengan')->nullable();

            // BAWAHAN
            $table->float('panjang_pinggang')->nullable();
            $table->float('pinggul')->nullable();
            $table->float('pisak')->nullable();
            $table->float('pangkal_paha')->nullable();

            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};
