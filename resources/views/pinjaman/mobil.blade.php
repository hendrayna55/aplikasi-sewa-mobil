@extends('layouts.app')

@section('title')
    Data Mobil
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
    
        const getDataMobil = () => {
            $.ajax({
                type: "GET",
                url: "{{ route('getDataMobil') }}",
                success: function (response) {
                    const mobil = response.data;
                    
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
                                            <button class="btn btn-sm btn-primary btn-sewa" data-index="${item.id}">Sewa</button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                    
                    $('#tabelData').DataTable({
                        responsive: true,
                        autoWidth: false,
                    });
                }
            });
        };
    
        function formatRupiah(angka) {
            return 'Rp' + parseInt(angka).toLocaleString('id-ID');
        }
    
        function setAlert(element, message = "", type = "success") {
            element.classList.toggle('tw-invisible', !message);
            element.classList.toggle('text-success', type === "success");
            element.classList.toggle('text-danger', type === "error");
            element.innerHTML = message;
        }
    
        $(document).on('click', '.btn-sewa', function(){
            const dataId = $(this).data('index');
            
            $.ajax({
                url: `/data-peminjaman/modal-tambah`,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: dataId
                },
                success: function (modalContent) {
                    $('body').append(modalContent);
                    $(`#modalTambahSewa`).modal('show');
    
                    $('#modalTambahSewa').on('shown.bs.modal', function() {
                        const tarif_mobil = document.getElementById('tarif_mobil').value;
                        const submitBtn = document.getElementById('submitBtn');
                        submitBtn.disabled = true;
                        const mobil_pilihan = document.getElementById('mobil_pilihan');
                        const nominal_pembayaran = document.getElementById('nominal_pembayaran');
                        const tanggal_peminjaman = document.getElementById('tanggal_peminjaman');
                        const alertPeminjaman = document.getElementById('alertPeminjaman');
                        const tanggal_pengembalian = document.getElementById('tanggal_pengembalian');
                        const alertPengembalian = document.getElementById('alertPengembalian');
                        const durasi_peminjaman = document.getElementById('durasi_peminjaman');
                        const nominal_pembayaran_view = document.getElementById('nominal_pembayaran_view');
    
                        function calculateDaysDifference(startDate, endDate) {
                            const start = new Date(startDate);
                            const end = new Date(endDate);
                            return Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                        }
    
                        function validateDates() {
                            const days = calculateDaysDifference(tanggal_peminjaman.value, tanggal_pengembalian.value);
                            
                            if (days <= 0) {
                                durasi_peminjaman.value = '0 Hari';
                                nominal_pembayaran.value = 0;
                                nominal_pembayaran_view.value = formatRupiah(0);
                                submitBtn.disabled = true;
    
                                alertPeminjaman.textContent = "Tanggal pengembalian tidak benar.";
                                alertPeminjaman.classList.remove("tw-invisible", "text-success");
                                alertPeminjaman.classList.add("text-danger");
                                return false;
                            } else {
                                alertPeminjaman.classList.add("tw-invisible");
                                alertPeminjaman.classList.remove("text-danger");
                                return true;
                            }
                        }
    
                        function checkDateAvailability() {
                            if (!validateDates()) return;
    
                            $.ajax({
                                type: "POST",
                                url: "{{ route('cekTanggalPeminjaman') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    mobil_id: dataId,
                                    tanggal_peminjaman: tanggal_peminjaman.value,
                                    tanggal_pengembalian: tanggal_pengembalian.value,
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.jadwal === 'valid') {
                                        alertPeminjaman.classList.add("tw-invisible");
                                        alertPeminjaman.classList.remove("text-danger");
                                        submitBtn.disabled = false;
    
                                        const days = calculateDaysDifference(tanggal_peminjaman.value, tanggal_pengembalian.value);
                                        durasi_peminjaman.value = `${days} Hari`;
                                        const totalPayment = days * parseInt(tarif_mobil);
                                        nominal_pembayaran.value = totalPayment;
                                        nominal_pembayaran_view.value = formatRupiah(totalPayment);

                                        alertPeminjaman.textContent = response.message;
                                        alertPeminjaman.classList.remove("tw-invisible");
                                        alertPeminjaman.classList.add("text-success");
                                    } else {
                                        alertPeminjaman.textContent = response.message;
                                        alertPeminjaman.classList.remove("tw-invisible");
                                        alertPeminjaman.classList.add("text-danger");
                                        submitBtn.disabled = true;
                                    }
                                },
                                error: function() {
                                    alertPeminjaman.textContent = "Terjadi kesalahan saat memeriksa ketersediaan tanggal.";
                                    alertPeminjaman.classList.remove("tw-invisible");
                                    alertPeminjaman.classList.add("text-danger");
                                    submitBtn.disabled = true;
                                }
                            });
                        }
    
                        tanggal_peminjaman.addEventListener('input', checkDateAvailability);
                        tanggal_pengembalian.addEventListener('input', checkDateAvailability);
    
                        submitBtn.addEventListener('click', function() {                            
                            $.ajax({
                                type: "POST",
                                url: "{{ route('postDataSewa') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    mobil_id: mobil_pilihan.value,
                                    peminjam_id: "{{ Auth::user()->id }}",
                                    tanggal_peminjaman: tanggal_peminjaman.value,
                                    tanggal_pengembalian: tanggal_pengembalian.value,
                                    nominal_pembayaran: nominal_pembayaran.value
                                },
                                success: function(response) {
                                    Toast.fire({
                                        icon: "success",
                                        title: response.message
                                    });
                                    $('#modalTambahSewa').modal('hide');
                                    
                                    window.location.href = '/data-peminjaman';
                                },
                                error: function() {
                                    Toast.fire({
                                        icon: "error",
                                        title: "Gagal menambahkan data"
                                    });
                                    getDataMobil();
                                }
                            });
                        });
                    });
    
                    $('#modalTambahSewa').on('hidden.bs.modal', function () {
                        $(this).remove();
                        $('#modalTambahSewa').off('shown.bs.modal');
                        $('#modalTambahSewa').off('hidden.bs.modal');
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

                    <a href="{{ route('allCalendarJadwal') }}" class="btn btn-sm btn-primary">Lihat Semua Jadwal</a>
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