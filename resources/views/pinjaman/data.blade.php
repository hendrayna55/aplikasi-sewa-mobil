@extends('layouts.app')

@section('title')
    {{Auth::user()->role_id == 1 ? 'Data Pinjaman' : 'Pinjamanku'}}
@endsection

@push('styles')
    <link
        rel="stylesheet"
        type="text/css"
        href="{{asset('deskapp')}}/src/plugins/datatables/css/dataTables.bootstrap4.min.css"
    />
    <link
        rel="stylesheet"
        type="text/css"
        href="{{asset('deskapp')}}/src/plugins/datatables/css/responsive.bootstrap4.min.css"
    />
@endpush

@php
    $url = Auth::user()->role_id != 1 ? '/get-data/pinjamanku/' . $user->id : '/get-data/pinjaman';
@endphp

@push('scripts')
    <script src="{{asset('deskapp')}}/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('deskapp')}}/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('deskapp')}}/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('deskapp')}}/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    
    <!-- buttons for Export datatable -->
    <script src="{{asset('deskapp')}}/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="{{asset('deskapp')}}/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="{{asset('deskapp')}}/src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="{{asset('deskapp')}}/src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="{{asset('deskapp')}}/src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="{{asset('deskapp')}}/src/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="{{asset('deskapp')}}/src/plugins/datatables/js/vfs_fonts.js"></script>
    <!-- Datatable Setting js -->
    <script src="{{asset('deskapp')}}/vendors/scripts/datatable-setting.js"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        const divTabel = document.getElementById('divTabel');
        
        const formatRupiah = (angka) => {
            return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
        };

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
        }

        const getDataPinjaman = () => {
            $.ajax({
                type: "GET",
                url: "{{$url}}",
                data: {
                    _token: "{{csrf_token()}}",
                    user_id: "{{$user->id}}"
                },
                success: function (response) {
                    const dataPinjaman = response.data;

                    // Jika tabel sudah diinisialisasi sebagai DataTable, hancurkan terlebih dahulu
                    if ($.fn.DataTable.isDataTable('#tabelData')) {
                        $('#tabelData').DataTable().destroy();
                    }
                    
                    divTabel.innerHTML = `
                        <table id="tabelData" class="data-table table stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th class="table-plus">#</th>
                                    <th>Mobil</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Nominal Pembayaran</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Unit</th>
                                    <th class="datatable-nosort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${dataPinjaman.map((item, index) => `
                                    <tr>
                                        <td class="table-plus">${index + 1}</td>
                                        <td>${item.mobil.plat_nomor} - ${item.mobil.merek} ${item.mobil.model}</td>
                                        <td>${formatDate(item.tanggal_peminjaman)}</td>
                                        <td>${formatDate(item.tanggal_pengembalian)}</td>
                                        <td>${formatRupiah(item.nominal_pembayaran)}</td>
                                        <td class="${item.metode_pembayaran_id == null ? 'text-danger' : 'text-primary'}">
                                            ${
                                                item.metode_pembayaran_id == null ? 'Belum memilih' : item.metode_pembayaran.nama_metode
                                            }
                                        </td>
                                        <td class="${item.status_pembayaran == 'Unpaid' ? 'text-danger' : 'text-primary'}">
                                            ${item.status_pembayaran} 
                                            ${
                                                item.status_pembayaran == 'Paid' ? 
                                                `<button class="btn btn-sm btn-status-bayar ${item.status_verifikasi == 'Unverified' ? 'text-danger' : 'text-success'}" data-index="${item.id}">(${item.status_verifikasi})</button>` 
                                                :
                                                ''
                                            }
                                        </td>

                                        <td class="">
                                            ${
                                                item.status_verifikasi == "Verified" ? 
                                                `<button class="btn btn-sm btn-status-mobil ${item.status_mobil == "Garasi" ? 'text-danger' : (item.status_mobil == "Diambil" ? 'text-primary' : 'text-success')}" data-index="${item.id}">${item.status_mobil}</button>`
                                                : 
                                                '-'
                                            }
                                        </td>

                                        <td class="text-nowrap">
                                            ${
                                                item.peminjam_id == "{{Auth::user()->id}}" ?
                                                item.status_pembayaran == 'Unpaid' ? `<button class="btn btn-sm btn-primary btn-bayar" data-index="${item.id}">Bayar</button>` : '-'
                                                :
                                                `<button class="btn btn-sm btn-danger btn-hapus-data" data-index="${item.id}">Hapus</button>`
                                            }
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;

                    // Inisialisasi ulang DataTable pada tabel baru
                    $('#tabelData').DataTable({
                        responsive: false,
                        autoWidth: false,
                        scrollX: true
                        // Tambahkan konfigurasi lainnya sesuai kebutuhan
                    });
                }
            });
        };

        function formCheck(status_mobil, button) {
            button.disabled = status_mobil.val() === "";
        }

        document.addEventListener('DOMContentLoaded', function(){
            getDataPinjaman();
        });
    </script>

    @if (Auth::user()->role_id == 1)
        <script>
            $(document).on('click', '.btn-status-bayar', function(){
                const dataId = $(this).data('index');
                
                $.ajax({
                    url: `/admin/data-peminjaman/modal-status-bayar/${dataId}`,
                    type: 'POST',
                    data: {
                        _token: "{{csrf_token()}}",
                    },
                    success: function (modalContent) {
                        // Handle the modal content here
                        $('body').append(modalContent);

                        // Show the modal
                        $(`#modalStatusBayar`).modal('show');

                        // Inisialisasi select2 setelah modal ditampilkan
                        $('#modalStatusBayar').on('shown.bs.modal', function() {
                            $('#status_pembayaran').select2({
                                dropdownParent: $('#modalStatusBayar') // Mengatur dropdown agar muncul di dalam modal
                            });

                            $('#status_verifikasi').select2({
                                dropdownParent: $('#modalStatusBayar') // Mengatur dropdown agar muncul di dalam modal
                            });

                            const submitBtn = document.getElementById('submitBtn');
                            const status_pembayaran = $('#status_pembayaran');
                            const status_verifikasi = $('#status_verifikasi');

                            // Event listener untuk tombol submit
                            submitBtn.addEventListener('click', function() {
                                $.ajax({
                                    type: "POST",
                                    url: `/admin/data-peminjaman/update-status-bayar/${dataId}`,
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        _method: "PUT",
                                        status_pembayaran: status_pembayaran.val(),
                                        status_verifikasi: status_verifikasi.val()
                                    },
                                    success: function(response) {
                                        Toast.fire({
                                            icon: "success",
                                            title: response.message
                                        });
                                        // Tutup modal setelah sukses
                                        $('#modalStatusBayar').modal('hide');

                                        getDataPinjaman();
                                    },
                                    error: function(errors) {
                                        Toast.fire({
                                            icon: "error",
                                            title: "Gagal menambahkan data",
                                        });

                                        getDataPinjaman();

                                        console.log(errors);
                                    }
                                });
                            });
                        });

                        // Remove modal from DOM after it is hidden
                        $('#modalStatusBayar').on('hidden.bs.modal', function () {
                            $(this).remove();
                            $('#modalStatusBayar').off('shown.bs.modal'); // Menghapus event listener
                            $('#modalStatusBayar').off('hidden.bs.modal'); // Menghapus event listener
                        });
                    },
                });
            });

            $(document).on('click', '.btn-status-mobil', function(){
                const dataId = $(this).data('index');
                
                $.ajax({
                    url: `/admin/data-peminjaman/modal-status-mobil/${dataId}`,
                    type: 'POST',
                    data: {
                        _token: "{{csrf_token()}}",
                    },
                    success: function (modalContent) {
                        // Handle the modal content here
                        $('body').append(modalContent);

                        // Show the modal
                        $(`#modalStatusMobil`).modal('show');

                        // Inisialisasi select2 setelah modal ditampilkan
                        $('#modalStatusMobil').on('shown.bs.modal', function() {
                            $('#status_mobil').select2({
                                dropdownParent: $('#modalStatusMobil') // Mengatur dropdown agar muncul di dalam modal
                            });

                            const submitBtn = document.getElementById('submitBtn');
                            const status_mobil = $('#status_mobil');
                            
                            formCheck(status_mobil, submitBtn);

                            // Update logo_metode berdasarkan nama_metode
                            status_mobil.on('change', function() {
                                formCheck(status_mobil, submitBtn);
                            });

                            // Event listener untuk tombol submit
                            submitBtn.addEventListener('click', function() {
                                $.ajax({
                                    type: "POST",
                                    url: `/admin/data-peminjaman/update-status-mobil/${dataId}`,
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        _method: "PUT",
                                        status_mobil: status_mobil.val()
                                    },
                                    success: function(response) {
                                        Toast.fire({
                                            icon: "success",
                                            title: response.message
                                        });
                                        // Tutup modal setelah sukses
                                        $('#modalStatusMobil').modal('hide');

                                        getDataPinjaman();
                                    },
                                    error: function(errors) {
                                        Toast.fire({
                                            icon: "error",
                                            title: "Gagal menambahkan data",
                                        });

                                        getDataPinjaman();

                                        console.log(errors);
                                    }
                                });
                            });
                        });

                        // Remove modal from DOM after it is hidden
                        $('#modalStatusMobil').on('hidden.bs.modal', function () {
                            $(this).remove();
                            $('#modalStatusMobil').off('shown.bs.modal'); // Menghapus event listener
                            $('#modalStatusMobil').off('hidden.bs.modal'); // Menghapus event listener
                        });
                    },
                });
            });

            $(document).on('click', '.btn-hapus-data', function(){
                const dataId = $(this).data('index');
                
                $.ajax({
                    url: `/admin/data-peminjaman/modal-hapus/${dataId}`,
                    type: 'POST',
                    data: {
                        _token: "{{csrf_token()}}",
                    },
                    success: function (modalContent) {
                        // Handle the modal content here
                        $('body').append(modalContent);

                        // Show the modal
                        $(`#modalHapusData`).modal('show');

                        // Inisialisasi select2 setelah modal ditampilkan
                        $('#modalHapusData').on('shown.bs.modal', function() {
                            const submitBtn = document.getElementById('submitBtn');

                            // Event listener untuk tombol submit
                            submitBtn.addEventListener('click', function() {
                                $.ajax({
                                    type: "POST",
                                    url: `/admin/data-peminjaman/hapus/${dataId}`,
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        _method: "DELETE",
                                    },
                                    success: function(response) {
                                        Toast.fire({
                                            icon: "success",
                                            title: response.message
                                        });
                                        // Tutup modal setelah sukses
                                        $('#modalHapusData').modal('hide');

                                        getDataPinjaman();
                                    },
                                    error: function(errors) {
                                        Toast.fire({
                                            icon: "error",
                                            title: "Gagal menghapus data",
                                        });

                                        getDataPinjaman();

                                        console.log(errors);
                                    }
                                });
                            });
                        });

                        // Remove modal from DOM after it is hidden
                        $('#modalHapusData').on('hidden.bs.modal', function () {
                            $(this).remove();
                            $('#modalHapusData').off('shown.bs.modal'); // Menghapus event listener
                            $('#modalHapusData').off('hidden.bs.modal'); // Menghapus event listener
                        });
                    },
                });
            });
        </script>
    @endif

    @if (Auth::user()->role_id == 2)
        <script>
            $(document).on('click', '.btn-bayar', function(){
                const dataId = $(this).data('index');
                
                $.ajax({
                    url: `/data-peminjaman/modal-bayar/${dataId}`,
                    type: 'POST',
                    data: {
                        _token: "{{csrf_token()}}",
                    },
                    success: function (modalContent) {
                        // Handle the modal content here
                        $('body').append(modalContent);

                        // Show the modal
                        $(`#modalBayarSewa`).modal('show');

                        // Inisialisasi select2 setelah modal ditampilkan
                        $('#modalBayarSewa').on('shown.bs.modal', function() {
                            $('#metode_pembayaran').select2({
                                dropdownParent: $('#modalBayarSewa') // Mengatur dropdown agar muncul di dalam modal
                            });

                            const submitBtn = document.getElementById('submitBtn');
                            const metode_pembayaran = $('#metode_pembayaran');
                            const bukti_pembayaran = document.getElementById('bukti_pembayaran');
                            
                            formCheck(metode_pembayaran, bukti_pembayaran, submitBtn);

                            // Update logo_metode berdasarkan nama_metode
                            metode_pembayaran.on('change', function() {
                                formCheck(metode_pembayaran, bukti_pembayaran, submitBtn);
                            });

                            // Event listener untuk input lainnya
                            bukti_pembayaran.addEventListener('change', () => formCheck(metode_pembayaran, bukti_pembayaran, submitBtn));

                            // Event listener untuk tombol submit
                            submitBtn.addEventListener('click', function() {   
                                // Membuat FormData untuk mengirim data termasuk file
                                const formData = new FormData();
                                formData.append('_token', "{{ csrf_token() }}");
                                formData.append('_method', "PUT");
                                formData.append('metode_pembayaran_id', metode_pembayaran.val());
                                formData.append('bukti_pembayaran', bukti_pembayaran.files[0]); // Mengambil file dari input
                                                        
                                $.ajax({
                                    type: "POST",
                                    url: `/data-peminjaman/update-bayar/${dataId}`,
                                    data: formData,
                                    processData: false, // Tidak memproses data
                                    contentType: false, // Tidak menetapkan contentType
                                    success: function(response) {
                                        Toast.fire({
                                            icon: "success",
                                            title: response.message
                                        });
                                        // Tutup modal setelah sukses
                                        $('#modalBayarSewa').modal('hide');

                                        getDataPinjaman();
                                    },
                                    error: function(errors) {
                                        Toast.fire({
                                            icon: "error",
                                            title: "Gagal menambahkan data",
                                        });

                                        getDataPinjaman();

                                        console.log(errors);
                                    }
                                });
                            });
                        });

                        // Remove modal from DOM after it is hidden
                        $('#modalBayarSewa').on('hidden.bs.modal', function () {
                            $(this).remove();
                            $('#modalBayarSewa').off('shown.bs.modal'); // Menghapus event listener
                            $('#modalBayarSewa').off('hidden.bs.modal'); // Menghapus event listener
                        });
                    },
                });
            });
        </script>
    @endif
@endpush

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="title pb-20">
            <h2 class="h3 mb-0">@yield('title')</h2>
        </div>

        <div class="min-height-200px">
            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20 d-flex justify-content-between align-items-center">
                    <h4 class="text-blue h4">@yield('title')</h4>

                    {{-- <button class="btn btn-sm btn-primary" type="button" id="btnAdd">Tambah</button> --}}
                </div>

                <div class="pb-20" id="divTabel">
                    <table class="data-table table stripe hover nowrap" id="tabelData">
                        <thead>
                            <tr>
                                <th class="table-plus">#</th>
                                <th>Merek</th>
                                <th>Model</th>
                                <th>Plat Nomor</th>
                                <th>Tarif Sewa</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Simple Datatable End -->
        </div>
    </div>
</div>
@endsection