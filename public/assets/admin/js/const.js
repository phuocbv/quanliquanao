const EMPTY_VALUE = '';

//check length
const SUPPLIER_NAME_LENGTH = 255;

//message
const SUPPLIER_NAME_EMPTY_MESSAGE = 'Không nhập tên';
const SUPPLIER_NAME_LENGTH_MESSAGE = 'Nhập quá 255';



let ajaxSetup = function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
};