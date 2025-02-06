<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('category')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        // ✅ PostgreSQL'de `id` sütununun sequence adını otomatik olarak bulacak ve başlangıç değerini ayarlayacak.
        $sequenceName = DB::selectOne("SELECT pg_get_serial_sequence('products', 'id') AS sequence_name")->sequence_name;
        DB::statement("ALTER SEQUENCE {$sequenceName} RESTART WITH 100;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
