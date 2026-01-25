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
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom google_id setelah email, BOLEH KOSONG (nullable)
            $table->string('google_id')->nullable()->after('email');
            
            // Password jadi nullable (karena login Google tidak butuh password)
            // Tapi mengubah kolom jadi nullable butuh package lain, 
            // jadi triknya nanti kita isi password acak saja.
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id');
        });
    }
};
