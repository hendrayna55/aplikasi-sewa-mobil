<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('nomor_sim')->unique();
            $table->text('alamat');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            [
                'nama_lengkap' => 'Administrator',
                'role_id' => 1,
                'email' => 'admin@admin.com',
                'nomor_sim' => '000123456789',
                'alamat' => 'Panyileukan, Kota Bandung',
                'password' => Hash::make('123')
            ],
            [
                'nama_lengkap' => 'Member',
                'role_id' => 2,
                'email' => 'member@gmail.com',
                'nomor_sim' => '000987654321',
                'alamat' => 'Cibiru, Kota Bandung',
                'password' => Hash::make('123')
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
