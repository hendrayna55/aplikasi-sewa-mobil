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
        Schema::create('metode_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_metode');
            $table->string('nomor_rekening');
            $table->string('pemilik_rekening');
            $table->string('logo_metode');
            $table->ulid('ulid')->unique();
            $table->timestamps();
        });

        DB::table('metode_pembayarans')->insert([
            [
                'nama_metode' => 'Bank CIMB Niaga',
                'nomor_rekening' => '76 230 5443 600',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'cimb.svg',
                'ulid' => '01j8hfe527m368xe4f8xwrrw0a'
            ],
            [
                'nama_metode' => 'Bank Rakyat Indonesia (BRI)',
                'nomor_rekening' => '04 050 1001 4105 65',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'bri.svg',
                'ulid' => '01j8hfe527n026xa0h2nbv2dmc'
            ],
            [
                'nama_metode' => 'Bank Central Asia (BCA)',
                'nomor_rekening' => '438 019 7613',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'bca.svg',
                'ulid' => '01j8hfe527jnx943c7bn56fyzd'
            ],
            [
                'nama_metode' => 'Bank Negara Indonesia (BNI)',
                'nomor_rekening' => '89 804 0501 5',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'bni.svg',
                'ulid' => '01j8hfe527qxaz3jhk2fj8j09a'
            ],
            [
                'nama_metode' => 'Bank BJB',
                'nomor_rekening' => '01 087 5408 7100',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'bjb.svg',
                'ulid' => '01j8hfe527a123bakwtcqpj3yw'
            ],
            [
                'nama_metode' => 'Bank BJB Syariah',
                'nomor_rekening' => '54 302 0602 1155',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'bjb-syariah.svg',
                'ulid' => '01j8hfe5272027f6qrqnpe0vqq'
            ],
            [
                'nama_metode' => 'Bank Mandiri',
                'nomor_rekening' => '13 200 8040 5013',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'mandiri.svg',
                'ulid' => '01j8hfe5271d0tfvv5e185ay2v'
            ],
            [
                'nama_metode' => 'Bank Central Asia (BCA)',
                'nomor_rekening' => '7750 317 001',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'bca.svg',
                'ulid' => '01j8hfe527b546x0k62632x7pr'
            ],
            [
                'nama_metode' => 'Bank Mandiri',
                'nomor_rekening' => '13000 13000 115',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'mandiri.svg',
                'ulid' => '01j8hfe527newmhytqa8mrrnbm'
            ],
            [
                'nama_metode' => 'Bank Negara Indonesia (BNI)',
                'nomor_rekening' => '018 2729 251',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'bni.svg',
                'ulid' => '01j8hfe5286xpaxy3jrnqqrvnn'
            ],
            [
                'nama_metode' => 'Bank Syariah Indonesia (BSI)',
                'nomor_rekening' => '7015517071',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'bsi.svg',
                'ulid' => '01j8hfe528qhbknbbkshsdyh4y'
            ],
            [
                'nama_metode' => 'Bank Permata Syariah',
                'nomor_rekening' => '377 101 2166',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'permata-syariah.svg',
                'ulid' => '01j8hfe5282v7pxcya1yt325wc'
            ],
            [
                'nama_metode' => 'Bank Rakyat Indonesia (BRI)',
                'nomor_rekening' => '33701001184309',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'bri.svg',
                'ulid' => '01j8hfe52824qqcvej7zk3c308'
            ],
            [
                'nama_metode' => 'Bank Mandiri',
                'nomor_rekening' => '1300 000 777 444',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'mandiri.svg',
                'ulid' => '01j8hfe528qyg32b642g6f2gan'
            ],
            [
                'nama_metode' => 'Bank Rakyat Indonesia (BRI)',
                'nomor_rekening' => '033701000930309',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'bri.svg',
                'ulid' => '01j8hfe528279a46nxqmwj6vcz'
            ],
            [
                'nama_metode' => 'Bank Mandiri',
                'nomor_rekening' => '13000 6677 5555',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'mandiri.svg',
                'ulid' => '01j8hfe528rm8vmv96aek11w17'
            ],
            [
                'nama_metode' => 'Bank Muamalat Indonesia',
                'nomor_rekening' => '10 10 10 60 60',
                'pemilik_rekening' => 'Bale Zakat Sodaqoh',
                'logo_metode' => 'muamalat.svg',
                'ulid' => '01j8hfe5287h5yahynt12whbff'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metode_pembayarans');
    }
};
