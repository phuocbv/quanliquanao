@if ($supplier)
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('supplier_index.modal.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">{{ trans('supplier_index.modal.name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ $supplier->name }}"
                           id="name" placeholder="{{ trans('supplier_index.modal.name') }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('index.modal.btn_close') }}</button>
                <button type="button" class="btn btn-primary" id="btn-edit-supplier" data-id="{{ $supplier->id }}">{{ trans('index.modal.btn_edit') }}</button>
            </div>
        </div>
    </div>
@endif