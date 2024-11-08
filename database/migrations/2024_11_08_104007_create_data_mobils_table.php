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
        Schema::create('data_mobils', function (Blueprint $table) {
            $table->id();
            $table->string('merek');
            $table->string('model');
            $table->string('plat_nomor')->unique();
            $table->decimal('tarif_sewa',13,2);
            $table->timestamps();
        });

        DB::table('data_mobils')->insert([
            [
                'merek' => 'Toyota',
                'model' => 'Avanza (MPV)',
                'plat_nomor' => 'D 2276 BZE',
                'tarif_sewa' => '350000',
            ],
            [
                'merek' => 'Honda',
                'model' => 'Brio (City Car)',
                'plat_nomor' => 'D 1357 CKT',
                'tarif_sewa' => '300000',
            ],
            [
                'merek' => 'Suzuki',
                'model' => 'Ertiga (MPV)',
                'plat_nomor' => 'D 7891 FDA',
                'tarif_sewa' => '320000',
            ],
            [
                'merek' => 'Mitsubishi',
                'model' => 'Xpander (MPV)',
                'plat_nomor' => 'D 4823 GHI',
                'tarif_sewa' => '400000',
            ],
            [
                'merek' => 'Daihatsu',
                'model' => 'Sigra (City Car)',
                'plat_nomor' => 'D 9632 JKL',
                'tarif_sewa' => '280000',
            ],
            [
                'merek' => 'Toyota',
                'model' => 'Fortuner (SUV)',
                'plat_nomor' => 'D 3198 MNO',
                'tarif_sewa' => '700000',
            ],
            [
                'merek' => 'Honda',
                'model' => 'CR-V (SUV)',
                'plat_nomor' => 'D 5742 PQR',
                'tarif_sewa' => '650000',
            ],
            [
                'merek' => 'Nissan',
                'model' => 'Grand Livina (MPV)',
                'plat_nomor' => 'D 8421 STU',
                'tarif_sewa' => '300000',
            ],
            [
                'merek' => 'Hyundai',
                'model' => 'Ioniq (Electric Car)',
                'plat_nomor' => 'D 2673 VWX',
                'tarif_sewa' => '850000',
            ],
            [
                'merek' => 'Kia',
                'model' => 'Seltos (SUV)',
                'plat_nomor' => 'D 6985 YZA',
                'tarif_sewa' => '550000',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mobils');
    }
};
