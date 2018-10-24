let Add = (function () {
    let listAddField = $('#listAddField');

    let btnAddField = $('#btnAddField');

    let handleAddField = function () {
        btnAddField.on('click', function () {
            listAddField.append('<div class="form-group row"><div class="col-sm-10">' +
                '<input class="form-control" name="field[]"></div><div class="col-sm-2">' +
                '<button class="btn btn-danger form-control btnDeleteField" type="button">Delete</button></div></div>');
        });
    };

    let handleDeleteField = function () {
        listAddField.on('click', '.btnDeleteField', function () {
            $(this).closest('.row').remove();
        });
    };


    let handleValidate = function () {
        let form = $('#formAddSupplier')
        form.validate({
            errorElement: 'span', // default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: '',  // validate all fields including form hidden input
            rules: {
                name: {
                    required: true
                },
                product_code: {
                    required: true,
                },
                supplier: {
                    required: true
                },
                brand: {
                    required: true
                },
                category: {
                    required: true,
                },
                gender: {
                    required: true
                }
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group .form-control').addClass('is-invalid') // set invalid class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group .form-control').removeClass('is-invalid') // set invalid class to the control group
                    .closest('.form-group .form-control').addClass('is-valid')
            },
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent())
                } else {
                    error.insertAfter(element)
                }
            },
            success: function (label) {
                label
                    .closest('.form-group .form-control').removeClass('is-invalid') // set success class to the control group
            }
        })
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

    return {
        init: function () {
            handleAddField();
            handleDeleteField();
            handleToastrNotifs();
            handleValidate();
        }
    }
})();

jQuery(document).ready(function () {
    Add.init()
});
