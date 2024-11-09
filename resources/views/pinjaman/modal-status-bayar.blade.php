<div
    class="modal fade bs-example-modal-lg"
    id="modalStatusBayar"
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
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="peminjam" class="fw-bold">Peminjam</label>
                            <input type="text" class="form-control" id="peminjam" value="{{$data->peminjam->nama_lengkap}}" readonly disabled/>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="identitas_mobil" class="fw-bold">Data Mobil</label>
                            <input type="text" class="form-control" id="identitas_mobil" value="{{$data->mobil->plat_nomor . ' - ' . $data->mobil->merek . ' ' . $data->mobil->model}}" readonly disabled/>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="tanggal_peminjaman" class="fw-bold">Tanggal Peminjaman</label>
                            <input type="text" id="tanggal_peminjaman" class="form-control" value="{{date('d F Y', strtotime($data->tanggal_peminjaman))}}" readonly disabled/>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="tanggal_pengembalian" class="fw-bold">Tanggal Pengembalian</label>
                            <input type="text" id="tanggal_pengembalian" class="form-control" value="{{date('d F Y', strtotime($data->tanggal_pengembalian))}}" readonly disabled/>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="status_pembayaran" class="fw-bold">Status Pembayaran</label>
                            <select name="status_pembayaran" id="status_pembayaran" class="form-control select2" style="width: 100%;" required>
                                <option value="" selected disabled>-- Pilih Status Mobil --</option>

                                @foreach (['Paid', 'Unpaid'] as $statusBayar)
                                    <option value="{{$statusBayar}}" {{(old('status_pembayaran', $data->status_pembayaran) == $statusBayar) ? 'selected' : ''}}>{{$statusBayar}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="status_verifikasi" class="fw-bold">Verifikasi Pembayaran</label>
                            <select name="status_verifikasi" id="status_verifikasi" class="form-control select2" style="width: 100%;" required>
                                <option value="" selected disabled>-- Pilih Status Mobil --</option>

                                @foreach (['Verified', 'Unverified'] as $statusVerifikasi)
                                    <option value="{{$statusVerifikasi}}" {{(old('status_verifikasi', $data->status_verifikasi) == $statusVerifikasi) ? 'selected' : ''}}>{{$statusVerifikasi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="bukti_pembayaran" class="fw-bold">Bukti Pembayaran</label>
                            <a href="{{asset('website-resource/bukti-pembayaran/' . $data->bukti_pembayaran)}}" target="_blank">
                                <img src="{{asset('website-resource/bukti-pembayaran/' . $data->bukti_pembayaran)}}" alt="Bukti Pembayaran" id="bukti_pembayaran" class="mx-auto img-fluid" width="200px">
                            </a>
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
                    Save
                </button>
            </div>
        </div>
    </div>
</div>