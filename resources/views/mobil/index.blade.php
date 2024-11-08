@extends('layouts.app')

@section('title')
    Data Mobil
@endsection

@push('scripts')
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

        const getDataMobil = () => {
            $.ajax({
                type: "GET",
                url: "{{route('getDataMobil')}}",
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
                                    <th>Merek</th>
                                    <th>Model</th>
                                    <th>Plat Nomor</th>
                                    <th>Tarif Sewa</th>
                                    <th class="datatable-nosort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${mobil.map((item, index) => `
                                    <tr>
                                        <td class="table-plus">${index + 1}</td>
                                        <td>${item.merek}</td>
                                        <td>${item.model}</td>
                                        <td>${item.plat_nomor}</td>
                                        <td>${formatRupiah(item.tarif_sewa)} / Hari</td>
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

        function formCheck(merek, model, plat_nomor, tarif_sewa, button) {
            button.disabled = merek.value === "" || model.value === "" || plat_nomor.value === "" || tarif_sewa.value === "";
        }

        const btnAdd = document.getElementById('btnAdd');

        btnAdd.addEventListener('click', function(){
            $.get("{{ route('modalTambahMobil') }}",function(modalContent){
                // Append modal content to body
                $('body').append(modalContent);

                // Show the modal
                $(`#modalTambahMobil`).modal('show');

                // Remove modal from DOM after it is hidden
                $(`#modalTambahMobil`).on('hidden.bs.modal', function () {
                    $(this).remove();
                });

                const submitBtn = document.getElementById('submitBtn');

                const merek = document.getElementById('merek');
                const model = document.getElementById('model');
                const plat_nomor = document.getElementById('plat_nomor');
                const tarif_sewa = document.getElementById('tarif_sewa');

                formCheck(merek, model, plat_nomor, tarif_sewa, submitBtn);

                // Tambahkan event listener pada kedua input
                [merek, model, plat_nomor, tarif_sewa].forEach(input => {
                    input.addEventListener('input', () => formCheck(merek, model, plat_nomor, tarif_sewa, submitBtn));
                });

                submitBtn.addEventListener('click', function(){
                    $.ajax({
                        type: "POST",
                        url: "{{ route('postDataMobil') }}",
                        data: {
                            _token: "{{csrf_token()}}",
                            merek : merek.value,
                            model : model.value,
                            plat_nomor : plat_nomor.value,
                            tarif_sewa : tarif_sewa.value
                        },
                        success: function (response) {
                            Toast.fire({
                                icon: "success",
                                title: response.message
                            });
                        },
                        error: function (errors) {
                            Toast.fire({
                                icon: "error",
                                title: "Gagal menambahkan data",
                            });
                            console.log(errors);
                        }
                    });
                    
                    // Show the modal
                    $(`#modalTambahMobil`).modal('hide');

                    // Remove modal from DOM after it is hidden
                    $(`#modalTambahMobil`).on('hidden.bs.modal', function () {
                        $(this).remove();
                    });

                    getDataMobil();
                });
            });
        });

        $(document).on('click', '.btn-edit', function(){
            const dataId = $(this).data('index');
            
            $.ajax({
                url: `/admin/data-mobil/modal-edit/${dataId}`,
                type: 'GET',
                success: function (modalContent) {
                    // Handle the modal content here
                    $('body').append(modalContent);

                    // Show the modal
                    $(`#modalEditMobil`).modal('show');

                    // Remove modal from DOM after it is hidden
                    $(`#modalEditMobil`).on('hidden.bs.modal', function () {
                        $(this).remove();
                    });
                    
                    const submitBtn = document.getElementById('submitBtn');

                    const merek = document.getElementById('merek');
                    const model = document.getElementById('model');
                    const plat_nomor = document.getElementById('plat_nomor');
                    const tarif_sewa = document.getElementById('tarif_sewa');

                    formCheck(merek, model, plat_nomor, tarif_sewa, submitBtn);

                    // Tambahkan event listener pada kedua input
                    [merek, model, plat_nomor, tarif_sewa].forEach(input => {
                        input.addEventListener('input', () => formCheck(merek, model, plat_nomor, tarif_sewa, submitBtn));
                    });

                    submitBtn.addEventListener('click', function(){
                        $.ajax({
                            type: "PUT",
                            url: `/admin/data-mobil/update/${dataId}`,
                            data: {
                                _token: "{{csrf_token()}}",
                                merek : merek.value,
                                model : model.value,
                                plat_nomor : plat_nomor.value,
                                tarif_sewa : tarif_sewa.value
                            },
                            success: function (response) {
                                if (response.success === true) {
                                    Toast.fire({
                                        icon: "success",
                                        title: response.message
                                    });

                                    // Show the modal
                                    $(`#modalEditMobil`).modal('hide');
            
                                    // Remove modal from DOM after it is hidden
                                    $(`#modalEditMobil`).on('hidden.bs.modal', function () {
                                        $(this).remove();
                                    });
                                } else {
                                    Toast.fire({
                                        icon: "error",
                                        title: "Gagal update data"
                                    });
                                    // Show the modal
                                    $(`#modalEditMobil`).modal('hide');
            
                                    // Remove modal from DOM after it is hidden
                                    $(`#modalEditMobil`).on('hidden.bs.modal', function () {
                                        $(this).remove();
                                    });
                                }
                            },
                            error: function(errors){
                                alert('Gagal update data');
                            }
                        });

                        getDataMobil();
                    });
                },
            });
        });

        $(document).on('click', '.btn-hapus', function(){
            const dataId = $(this).data('index');
            
            $.ajax({
                url: `/admin/data-mobil/modal-hapus/${dataId}`,
                type: 'GET',
                success: function (modalContent) {
                    // Handle the modal content here
                    $('body').append(modalContent);

                    // Show the modal
                    $(`#modalHapusMobil`).modal('show');

                    // Remove modal from DOM after it is hidden
                    $(`#modalHapusMobil`).on('hidden.bs.modal', function () {
                        $(this).remove();
                    });

                    const submitBtn = document.getElementById('submitBtn');

                    submitBtn.addEventListener('click', function(){
                        $.ajax({
                            type: "DELETE",
                            url: `/admin/data-mobil/hapus/${dataId}`,
                            data: {
                                _method : "DELETE",
                                _token : "{{ csrf_token() }}",
                            },
                            success: function (response) {
                                if (response.success === true) {
                                    Toast.fire({
                                        icon: "success",
                                        title: response.message
                                    });

                                    // Show the modal
                                    $(`#modalHapusMobil`).modal('hide');
            
                                    // Remove modal from DOM after it is hidden
                                    $(`#modalHapusMobil`).on('hidden.bs.modal', function () {
                                        $(this).remove();
                                    });
                                } else {
                                    Toast.fire({
                                        icon: "error",
                                        title: "Gagal delete data"
                                    });
                                    // Show the modal
                                    $(`#modalHapusMobil`).modal('hide');
            
                                    // Remove modal from DOM after it is hidden
                                    $(`#modalHapusMobil`).on('hidden.bs.modal', function () {
                                        $(this).remove();
                                    });
                                }
                            },
                            error: function(errors){
                                alert('Gagal delete data');
                            }
                        });

                        getDataMobil();
                    });
                },
            });
        });

        document.addEventListener('DOMContentLoaded', function(){
            getDataMobil();
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

        <div class="footer-wrap pd-20 mb-20 card-box">
            DeskApp - Bootstrap 4 Admin Template By
            <a href="https://github.com/dropways" target="_blank"
                >Ankit Hingarajiya</a
            >
        </div>
    </div>
</div>
@endsection