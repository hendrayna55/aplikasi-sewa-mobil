<div
    class="modal fade bs-example-modal-lg"
    id="modalHapusData"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header tw-bg-red-600">
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
                <p>Apakah anda yakin ingin menghapus Peminjaman <span class="tw-font-bold">Mobil {{$data->mobil->merek}} {{$data->mobil->model}}</span> oleh {{$data->peminjam->nama_lengkap}} ini?</p>
            </div>

            <div class="modal-footer justify-content-between">
                <button
                    type="button"
                    class="btn btn-sm btn-secondary"
                    data-dismiss="modal"
                >
                    Close
                </button>
                <button type="button" id="submitBtn" class="btn btn-sm btn-danger">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>