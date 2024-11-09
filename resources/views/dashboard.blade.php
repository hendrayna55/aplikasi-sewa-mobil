@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="title pb-20">
                <h2 class="h3 mb-0">@yield('title')</h2>
            </div>

            <div class="title pb-20">
                <h2 class="h3 mb-0">Selamat Datang, <span class="tw-text-md">{{Auth::user()->nama_lengkap}}</span></h2>
            </div>

            <div class="row pb-10">
                <div class="col-md-8 mb-20">
                    <div class="card card-box">
                        <div class="card-header">{{date('l, d F Y', strtotime(Carbon\Carbon::now()))}}</div>
                        <div class="card-body">
                            <blockquote class="mb-0">
                                <p class="mb-2">
                                    Selamat datang di aplikasi sewa mobil. Silahkan lihat data mobil untuk memulai pengajuan sewa mobil.
                                </p>
                                <footer class="blockquote-footer">
                                    <a href="https://instagram.com/rhie.kenji" target="_blank">Hendra Ahmadillah,</a>
                                    <cite title="Source Title">Developer</cite>
                                </footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection