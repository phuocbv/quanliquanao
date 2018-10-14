let Index = (function () {
    let datatable;
    let addSupplierModal = $('#addSupplierModal');
    let editSupplierModal = $('#editSupplierModal');
    let btnShowModalAddSupplier = $('#btnShowModalAddSupplier')
    let btnAddSupplier = $('#btn-add-supplier');
    let nameSupplier = $('#name');
    let currentEdit;

    let handleTables = function () {
        datatable = $('#responsive-datatable').DataTable({
            responsive: true
        });
    };

    let handleToastrNotifs = function () {
        toastr.options = {
            'closeButton': true,
            'debug': false,
            'positionClass': 'toast-top-right',
            'onclick': null,
            'showDuration': '1000',
            'hideDuration': '1000',
            'timeOut': '3000',
            'extendedTimeOut': '1000',
            'showEasing': 'swing',
            'hideEasing': 'linear',
            'showMethod': 'fadeIn',
            'hideMethod': 'fadeOut'
        }
    };

    let ajaxSetup = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    };

    let handleShowAddModal = function () {
        btnShowModalAddSupplier.on('click', function () {
            addSupplierModal.find('.invalid-feedback').each(function () {
                $(this).empty();
            });
            addSupplierModal.find('.form-control').each(function () {
                $(this).removeClass('is-invalid');
                $(this).val('');
            });
            addSupplierModal.modal('show');
        });
    };

    let handleSubmitAddSupplier = function () {
        btnAddSupplier.on('click', function () {
            let name = nameSupplier.val();
            nameSupplier.removeClass('is-invalid');
            nameSupplier.closest('.form-group').find('.invalid-feedback').html(EMPTY_VALUE);

            if (name === EMPTY_VALUE) {
                nameSupplier.addClass('is-invalid');
                nameSupplier.closest('.form-group').find('.invalid-feedback').html(SUPPLIER_NAME_EMPTY_MESSAGE);
                return;
            }
            if (name.length > SUPPLIER_NAME_LENGTH) {
                nameSupplier.addClass('is-invalid');
                nameSupplier.closest('.form-group').find('.invalid-feedback').html(SUPPLIER_NAME_LENGTH_MESSAGE);
                return;
            }

            let data = {
                name: name
            };
            ajaxSetup();
            let ajax = $.ajax({
                type: 'POST',
                url: urlAddSupplier,
                data: data
            });
            ajax.done(function (data) {
                if (data.status) {
                    datatable.row.add([
                        data.data.id,
                        data.data.name,
                        '<i class="icon-im icon-im-pencil" style="cursor: pointer" data-id="' + data.data.id + '"></i>'
                    ]).draw();
                    addSupplierModal.modal('hide');
                    toastr['success']('Supplier Add', 'Success');
                } else {
                    let messages = '';
                    data.message.forEach(function (value) {
                        messages += value;
                    });
                    toastr['error'](messages, 'Error');
                }
            });
        });
    };

    let handleShowEditModal = function () {
        $('#responsive-datatable').on('click', '.icon-im.icon-im-pencil', function () {
            currentEdit = $(this);
            let ajax = $.ajax({
                type: 'GET',
                url: urlEditSupplier,
                data: {
                    id: $(this).data('id')
                }
            });
            ajaxSetup();
            ajax.done(function (data) {
                if (data.status) {
                    editSupplierModal.html(data.data);
                    editSupplierModal.modal('show');
                }
            });
        });
    };

    let handleSubmitEditSupplier = function () {
        editSupplierModal.on('click', '#btn-edit-supplier', function () {
            let id = $(this).data('id');
            let nameSupplier = editSupplierModal.find('#name');
            nameSupplier.removeClass('is-invalid');
            nameSupplier.closest('.form-group').find('.invalid-feedback').html(EMPTY_VALUE);

            if (nameSupplier.val() === EMPTY_VALUE) {
                nameSupplier.addClass('is-invalid');
                nameSupplier.closest('.form-group').find('.invalid-feedback').html(SUPPLIER_NAME_EMPTY_MESSAGE);
                return;
            }
            if (nameSupplier.val().length > SUPPLIER_NAME_LENGTH) {
                nameSupplier.addClass('is-invalid');
                nameSupplier.closest('.form-group').find('.invalid-feedback').html(SUPPLIER_NAME_LENGTH_MESSAGE);
                return;
            }

            let data = {
                id: id,
                name: nameSupplier.val()
            };
            let ajax = $.ajax({
                type: 'PUT',
                url: urlUpdateSupplier,
                data: data
            });
            ajaxSetup();
            ajax.done(function (data) {
                if (data.status) {
                    let tr = currentEdit.closest('tr');
                    $(tr.find('td')[1]).html(nameSupplier.val());
                    editSupplierModal.modal('hide');
                    toastr['success']('Supplier Edit', 'Success');
                } else {
                    let messages = '';
                    data.message.forEach(function (value) {
                        messages += value;
                    });
                    toastr['error'](messages, 'Error');
                }
            });
        });
    };

    return {
        // main function to initiate the module
        init: function () {
            handleTables();
            handleToastrNotifs();
            handleShowAddModal();
            handleSubmitAddSupplier();
            handleShowEditModal();
            handleSubmitEditSupplier();
        }
    }
})();

jQuery(document).ready(function () {
    Index.init()
});
