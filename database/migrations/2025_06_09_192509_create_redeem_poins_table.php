<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redeem_poins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembeli_id')->constrained('pembelis')->onDelete('cascade');
            $table->foreignId('merchandise_id')->constrained('merchandises')->onDelete('cascade');
            $table->enum('status', ['belum diambil', 'sudah diambil'])->default('belum diambil');
            $table->date('tanggal_ambil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redeem_poins');
    }
};
