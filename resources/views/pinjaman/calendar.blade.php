@extends('layouts.app')

@section('title')
    Kalender Sewa
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

    <style>
        #external-events .fc-event {
            margin-bottom: 5px;
            padding: 4px;
        }
    </style>
    
@endpush

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi array untuk menyimpan data pinjaman yang akan ditampilkan di kalender
            var dataPinjaman = [];

            // Daftar warna kontras tinggi yang tetap nyaman untuk teks putih
            const colors = [
                '#1F77B4', // Light Blue
                '#FF7F0E', // Soft Orange
                '#2CA02C', // Medium Green
                '#D62728', // Soft Red
                '#9467BD', // Medium Purple
                '#8C564B', // Brownish
                '#E377C2', // Pink
                '#7F7F7F', // Gray
                '#BCBD22', // Yellow-Green
                '#17BECF', // Teal
            ];

            // Ambil elemen #external-events
            const externalEventsEl = document.getElementById('external-events');
            externalEventsEl.innerHTML = ''; // Bersihkan konten yang ada

            // Data mobil diambil dari PHP ke dalam JavaScript
            const mobils = @json($mobils);

            // Buat peta warna untuk setiap mobil berdasarkan indeks
            const colorMap = {};

            // Tambahkan setiap mobil sebagai elemen baru ke #external-events
            mobils.forEach((mobil, index) => {
                // Tentukan warna untuk mobil ini berdasarkan indeks
                const color = colors[index % colors.length];
                colorMap[mobil.id] = color; // Simpan warna dalam peta berdasarkan ID mobil

                // Buat elemen div baru untuk setiap mobil
                const eventEl = document.createElement('div');
                eventEl.classList.add('fc-event', 'tw-rounded-md', 'tw-shadow-md', 'text-white', 'tw-text-xs', 'p-2', 'mb-2');
                eventEl.textContent = `${mobil.plat_nomor} - ${mobil.merek} ${mobil.model}`;
                
                // Tetapkan warna latar belakang dari colorMap
                eventEl.style.backgroundColor = color;

                // Tambahkan elemen ke #external-events
                externalEventsEl.appendChild(eventEl);
            });

            // Ambil data pinjaman dari server yang sudah di-JSON-kan melalui Laravel
            const pinjaman = @json($data);

            // Proses data pinjaman menjadi format yang sesuai untuk FullCalendar
            pinjaman.forEach(item => {
                const dataBaru = {
                    title: `${item.mobil.plat_nomor} - ${item.mobil.merek} ${item.mobil.model}`, // Judul dari pinjaman
                    start: item.tanggal_peminjaman, // Tanggal mulai pinjaman
                    end: item.tanggal_pengembalian, // Tanggal selesai pinjaman
                    backgroundColor: colorMap[item.mobil.id], // Gunakan warna dari colorMap
                    borderColor: colorMap[item.mobil.id], // Gunakan warna yang sama untuk border
                    allDay: true // Atur agar pinjaman ditampilkan sepanjang hari
                };

                // Tambahkan data pinjaman ke array dataPinjaman
                dataPinjaman.push(dataBaru);
            });

            // Inisialisasi Calendar
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: false,
                droppable: false, // Disable drag-and-drop
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,multiMonthYear'
                },
                events: dataPinjaman // Set array dataPinjaman sebagai events di FullCalendar
            });

            calendar.render();
        });

    </script>
@endpush

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="title">
                                    <h4>@yield('title')</h4>
                                </div>
                                <nav aria-label="breadcrumb" role="navigation">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('dataMobilUser') }}">Data Mobil</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            @yield('title')
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            
                            <a href="{{route('dataMobilUser')}}" class="btn btn-sm btn-primary float-end">Kembali</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="pd-20 mb-30">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Data Mobil</h4>
                            </div>
                            <div class="card-body">
                                <!-- the events -->
                                <div id="external-events" class="">
                                    {{-- @foreach ($mobils as $mobil)
                                        <div class="fc-event tw-rounded-md tw-shadow-md bg-success text-white p-2 mb-2">{{$mobil->merek}} {{$mobil->model}}</div>
                                    @endforeach --}}
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-9">
                        <div class="calendar-wrap">
                            <div class="card-box p-3">
                                <div id="calendar"></div>
                            </div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection