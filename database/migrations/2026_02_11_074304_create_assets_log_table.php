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
        Schema::create('assets_log', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel assets (Jika aset dihapus, log-nya ikut terhapus)
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            
            // Relasi ke tabel users (Siapa yang melakukan perubahan)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // Aksi yang dilakukan (contoh: 'created', 'updated', 'checkout', 'checkin')
            $table->string('action'); 
            
            // Catatan tambahan (opsional)
            $table->text('notes')->nullable(); 
            
            $table->timestamps(); // Mencatat kapan aksi tersebut terjadi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets_log');
    }
};
