@extends('layouts.app')

@section('title')
    Metode Pembayaran
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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

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
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

        const getDataMetodePembayaran = () => {
            $.ajax({
                type: "GET",
                url: "{{route('getMetodePembayaran')}}",
                success: function (response) {
                    const mobil = response.data;

                    // Jika tabel sudah diinisialisasi sebagai DataTable, hancurkan terlebih dahulu
                    if ($.fn.DataTable.isDataTable('#tabelData')) {
                        $('#tabelData').DataTable().destroy();
                    }
                    
                    divTabel.innerHTML = `
                        <table id="tabelData" class="data-table table stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th class="table-plus">#</th>
                                    <th>Provider</th>
                                    <th>Nomor Rekening</th>
                                    <th>Pemilik Rekening</th>
                                    <th class="datatable-nosort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${mobil.map((item, index) => `
                                    <tr>
                                        <td class="table-plus">${index + 1}</td>
                                        <td>${item.nama_metode}</td>
                                        <td>${item.nomor_rekening}</td>
                                        <td>${item.pemilik_rekening}</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm btn-success btn-edit" data-index="${item.id}"><i class="bi bi-pen-fill"></i></button>
                                            <button class="btn btn-sm btn-danger btn-hapus" data-index="${item.id}"><i class="bi bi-trash-fill"></i></button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;

                    // Inisialisasi ulang DataTable pada tabel baru
                    $('#tabelData').DataTable({
                        responsive: true,
                        autoWidth: false,
                        // Tambahkan konfigurasi lainnya sesuai kebutuhan
                    });
                }
            });
        };

        function formCheck(nama_metode, nomor_rekening, pemilik_rekening, button) {
            button.disabled = nama_metode.val() === null || nomor_rekening.value === "" || pemilik_rekening.value === "";
        }

        const btnAdd = document.getElementById('btnAdd');

        btnAdd.addEventListener('click', function(){
            $.get("{{ route('modalTambahMetode') }}", function(modalContent) {
                // Append modal content to body
                $('body').append(modalContent);

                // Show the modal
                $('#modalTambahMetode').modal('show');

                // Inisialisasi select2 setelah modal ditampilkan
                $('#modalTambahMetode').on('shown.bs.modal', function() {
                    $('#nama_metode').select2({
                        dropdownParent: $('#modalTambahMetode') // Mengatur dropdown agar muncul di dalam modal
                    });

                    const submitBtn = document.getElementById('submitBtn');
                    const nama_metode = $('#nama_metode');
                    const nomor_rekening = document.getElementById('nomor_rekening');
                    const pemilik_rekening = document.getElementById('pemilik_rekening');
                    const logo_metode = document.getElementById('logo_metode');
                    
                    formCheck(nama_metode, nomor_rekening, pemilik_rekening, submitBtn);

                    // Update logo_metode berdasarkan nama_metode
                    nama_metode.on('change', function() {
                        formCheck(nama_metode, nomor_rekening, pemilik_rekening, submitBtn);
                        const selectedCode = nama_metode.find(':selected').data('code');
                        logo_metode.value = selectedCode || ''; // Set value atau kosong jika tidak ada
                    });

                    // Event listener untuk input lainnya
                    [nomor_rekening, pemilik_rekening].forEach(input => {
                        input.addEventListener('input', () => formCheck(nama_metode, nomor_rekening, pemilik_rekening, submitBtn));
                    });

                    // Event listener untuk tombol submit
                    submitBtn.addEventListener('click', function() {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('postDataMetode') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                nama_metode: nama_metode.val(),
                                nomor_rekening: nomor_rekening.value,
                                pemilik_rekening: pemilik_rekening.value,
                                logo_metode: logo_metode.value
                            },
                            success: function(response) {
                                Toast.fire({
                                    icon: "success",
                                    title: response.message
                                });
                                // Tutup modal setelah sukses
                                $('#modalTambahMetode').modal('hide');

                                getDataMetodePembayaran();
                            },
                            error: function(errors) {
                                Toast.fire({
                                    icon: "error",
                                    title: "Gagal menambahkan data",
                                });

                                getDataMetodePembayaran();

                                console.log(errors);
                            }
                        });
                    });
                });

                // Remove modal from DOM after it is hidden
                $('#modalTambahMetode').on('hidden.bs.modal', function () {
                    $(this).remove();
                    $('#modalTambahMetode').off('shown.bs.modal'); // Menghapus event listener
                    $('#modalTambahMetode').off('hidden.bs.modal'); // Menghapus event listener
                });
            });
        });

        $(document).on('click', '.btn-edit', function(){
            const dataId = $(this).data('index');
            
            $.ajax({
                url: `/admin/metode-pembayaran/modal-edit/${dataId}`,
                type: 'GET',
                success: function (modalContent) {
                    // Handle the modal content here
                    $('body').append(modalContent);

                    // Show the modal
                    $(`#modalEditMetode`).modal('show');

                    // Inisialisasi select2 setelah modal ditampilkan
                    $('#modalEditMetode').on('shown.bs.modal', function() {
                        $('#nama_metode').select2({
                            dropdownParent: $('#modalEditMetode') // Mengatur dropdown agar muncul di dalam modal
                        });

                        const submitBtn = document.getElementById('submitBtn');
                        const nama_metode = $('#nama_metode');
                        const nomor_rekening = document.getElementById('nomor_rekening');
                        const pemilik_rekening = document.getElementById('pemilik_rekening');
                        const logo_metode = document.getElementById('logo_metode');
                        
                        formCheck(nama_metode, nomor_rekening, pemilik_rekening, submitBtn);

                        // Update logo_metode berdasarkan nama_metode
                        nama_metode.on('change', function() {
                            formCheck(nama_metode, nomor_rekening, pemilik_rekening, submitBtn);
                            const selectedCode = nama_metode.find(':selected').data('code');
                            logo_metode.value = selectedCode || ''; // Set value atau kosong jika tidak ada
                        });

                        // Event listener untuk input lainnya
                        [nomor_rekening, pemilik_rekening].forEach(input => {
                            input.addEventListener('input', () => formCheck(nama_metode, nomor_rekening, pemilik_rekening, submitBtn));
                        });

                        // Event listener untuk tombol submit
                        submitBtn.addEventListener('click', function() {                            
                            $.ajax({
                                type: "PUT",
                                url: `/admin/metode-pembayaran/update/${dataId}`,
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    nama_metode: nama_metode.val(),
                                    nomor_rekening: nomor_rekening.value,
                                    pemilik_rekening: pemilik_rekening.value,
                                    logo_metode: logo_metode.value
                                },
                                success: function(response) {
                                    Toast.fire({
                                        icon: "success",
                                        title: response.message
                                    });
                                    // Tutup modal setelah sukses
                                    $('#modalEditMetode').modal('hide');

                                    getDataMetodePembayaran();
                                },
                                error: function(errors) {
                                    Toast.fire({
                                        icon: "error",
                                        title: "Gagal menambahkan data",
                                    });

                                    getDataMetodePembayaran();

                                    console.log(errors);
                                }
                            });
                        });
                    });

                    // Remove modal from DOM after it is hidden
                    $('#modalEditMetode').on('hidden.bs.modal', function () {
                        $(this).remove();
                        $('#modalEditMetode').off('shown.bs.modal'); // Menghapus event listener
                        $('#modalEditMetode').off('hidden.bs.modal'); // Menghapus event listener
                    });
                },
            });
        });

        $(document).on('click', '.btn-hapus', function(){
            const dataId = $(this).data('index');
            
            $.ajax({
                url: `/admin/metode-pembayaran/modal-hapus/${dataId}`,
                type: 'GET',
                success: function (modalContent) {
                    // Handle the modal content here
                    $('body').append(modalContent);

                    // Show the modal
                    $(`#modalHapusMetode`).modal('show');

                    // Inisialisasi select2 setelah modal ditampilkan
                    $('#modalHapusMetode').on('shown.bs.modal', function() {
                        const submitBtn = document.getElementById('submitBtn');

                        // Event listener untuk tombol submit
                        submitBtn.addEventListener('click', function() {                            
                            $.ajax({
                                type: "DELETE",
                                url: `/admin/metode-pembayaran/hapus/${dataId}`,
                                data: {
                                    _token: "{{ csrf_token() }}",
                                },
                                success: function(response) {
                                    Toast.fire({
                                        icon: "success",
                                        title: response.message
                                    });
                                    // Tutup modal setelah sukses
                                    $('#modalHapusMetode').modal('hide');

                                    getDataMetodePembayaran();
                                },
                                error: function(errors) {
                                    Toast.fire({
                                        icon: "error",
                                        title: "Gagal menambahkan data",
                                    });

                                    getDataMetodePembayaran();

                                    console.log(errors);
                                }
                            });
                        });
                    });

                    // Remove modal from DOM after it is hidden
                    $('#modalHapusMetode').on('hidden.bs.modal', function () {
                        $(this).remove();
                        $('#modalHapusMetode').off('shown.bs.modal'); // Menghapus event listener
                        $('#modalHapusMetode').off('hidden.bs.modal'); // Menghapus event listener
                    });
                },
            });
        });

        document.addEventListener('DOMContentLoaded', function(){
            getDataMetodePembayaran();
        });
    </script>
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

                    <button class="btn btn-sm btn-primary" type="button" id="btnAdd">Tambah</button>
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