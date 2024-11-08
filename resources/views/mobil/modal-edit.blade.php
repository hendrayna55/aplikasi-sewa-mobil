<div
    class="modal fade bs-example-modal-lg"
    id="modalEditMobil"
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
                            <label for="merek" class="fw-bold">Merek</label>
                            <input type="text" name="merek" id="merek" value="{{$data->merek}}" class="form-control" required/>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="model" class="fw-bold">Model</label>
                            <input type="text" name="model" id="model" value="{{$data->model}}" class="form-control" required/>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="plat_nomor" class="fw-bold">Plat Nomor</label>
                            <input type="text" name="plat_nomor" id="plat_nomor" value="{{$data->plat_nomor}}" class="form-control" required/>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="tarif_sewa" class="fw-bold">Tarif Sewa</label>
                            <input type="number" name="tarif_sewa" id="tarif_sewa" value="{{$data->tarif_sewa}}" class="form-control" required/>
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