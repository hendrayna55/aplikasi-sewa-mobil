<div
    class="modal fade"
    id="modalTambahSewa"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header tw-bg-blue-600">
                <h4 class="modal-title text-white" id="myLargeModalLabel">
                    {{$title}}
                </h4>
                <button
                    type="button"
                    class="close text-white"
                    data-dismiss="modal"
                    aria-hidden="true"
                >
                    ×
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="mobil_pilihan" class="fw-bold">Pilihan Mobil</label>
                            <input type="text" value="{{$mobil['plat_nomor']}} - {{$mobil['merek']}} {{$mobil['model']}}" class="form-control" readonly/>

                            <input type="hidden" name="mobil_id" id="mobil_pilihan" value="{{$mobil['id']}}" class="form-control" required/>

                            <input type="hidden" id="tarif_mobil" value="{{$mobil['tarif_sewa']}}" class="form-control" required/>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="tanggal_peminjaman" class="fw-bold">Tanggal Peminjaman</label>
                            <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" class="form-control" required/>

                            <p class="tw-invisible text-danger tw-text-sm tw-font-bold" id="alertPeminjaman"></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="tanggal_pengembalian" class="fw-bold">Tanggal Pengembalian</label>
                            <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" class="form-control" required/>

                            <p class="tw-invisible text-danger tw-text-sm tw-font-bold" id="alertPengembalian"></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="durasi_peminjaman" class="fw-bold">Durasi Peminjaman</label>
                            <input type="text" id="durasi_peminjaman" class="form-control" value="0 Hari" readonly disabled/>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="nominal_pembayaran" class="fw-bold">Nominal Pembayaran</label>
                            <input type="text" id="nominal_pembayaran_view" class="form-control" value="Rp0" readonly disabled/>

                            <input type="hidden" name="nominal_pembayaran" id="nominal_pembayaran" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button
                    type="button"
                    class="btn btn-sm btn-secondary"
                    data-dismiss="modal"
                >
                    Close
                </button>
                <button type="button" id="submitBtn" class="btn btn-sm btn-primary">
                    Ajukan
                </button>
            </div>
        </div>
    </div>
</div>