<div
    class="modal fade"
    id="modalTambahMetode"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
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
                            <label for="nama_metode" class="fw-bold">Jenis Metode</label>
                            <select name="nama_metode" id="nama_metode" class="form-control select2" style="width: 100%;" required>
                                <option value="" selected disabled>-- Pilih Metode Pembayaran --</option>

                                @foreach ($banks as $bank)
                                    <option value="{{$bank['name']}}" data-code="{{$bank['code']}}">{{$bank['name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="logo_metode" id="logo_metode" class="form-control" required/>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="nomor_rekening" class="fw-bold">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control" required/>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="pemilik_rekening" class="fw-bold">Pemilik Rekening</label>
                            <input type="text" name="pemilik_rekening" id="pemilik_rekening" class="form-control" required/>
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