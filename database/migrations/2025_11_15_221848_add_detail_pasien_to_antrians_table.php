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
       Schema::table('antrians', function (Blueprint $table) {
            $table->string('nik', 20)->nullable()->after('nama_pasien');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('nik');
            $table->string('no_hp', 20)->nullable()->after('jenis_kelamin');
            $table->text('alamat')->nullable()->after('no_hp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
                        $table->dropColumn(['nik', 'jenis_kelamin', 'no_hp', 'alamat']);
        });
    }
};
