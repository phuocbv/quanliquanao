let Edit = (function () {
    let addSupplierPricing = $('#addSupplierPricing');
    let addSupplierPricingModal = $('#addSupplierPricingModal');
    let btnAddSupplierPricing = $('#btn-add-supplier-pricing');
    let tableSupplierPricing = $('#table_supplier_pricing');
    let hiddenSupplierPricing = $('#hiddenSupplierPricing');

    let addEspPricing = $('#addEspPricing');
    let addEspPricingModal = $('#addEspPricingModal');
    let btnAddEspPricing = $('#btn-add-esp-pricing');
    let tableEspPricing = $('#table-esp-pricing');
    let hiddenEspPricing = $('#hiddenEspPricing');

    let loadEspPricingDefault = $('#loadEspPricingDefault');

    let handleAddSupplierPricing = function () {
        addSupplierPricing.on('click', function () {
            addSupplierPricingModal.modal('show');
            addSupplierPricingModal.find('.form-control').each(function () {
                $(this).val(EMPTY_VALUE);
            });
        });

        btnAddSupplierPricing.on('click', function () {
            let min = addSupplierPricingModal.find('#min');
            let max = addSupplierPricingModal.find('#max');
            let unitPrice = addSupplierPricingModal.find('#unit_price');

            let html = '<tr><td class="min">' + min.val() + '</td><td class="max">' + max.val() + '</td><td class="unit_price">' + unitPrice.val() + '</td>' +
                '<td><i class="icon-im icon-im-pencil" style="cursor: pointer"></i><i class="icon-im icon-im-bin" style="cursor: pointer; margin-left: 10px"></i></td></tr>';
            tableSupplierPricing.append(html);

            handleFillDataSupplierPricing();
            addSupplierPricingModal.modal('hide');
        });
    };

    let handleDeleteSupplierPricing = function () {
        tableSupplierPricing.on('click', '.icon-im.icon-im-bin', function () {
            $(this).closest('tr').remove();
            handleFillDataSupplierPricing();
        });
    };

    let handleFillDataSupplierPricing = function () {
        let listSupplierPricing = [];
        tableSupplierPricing.find('tr').each(function () {
            let min = $(this).find('.min').html().trim();
            let max = $(this).find('.max').html().trim();
            let unit_price = $(this).find('.unit_price').html().trim();
            listSupplierPricing.push({min, max, unit_price});
        });
        hiddenSupplierPricing.val(JSON.stringify(listSupplierPricing));
    };

    let handleAddEspPricing = function () {
        addEspPricing.on('click', function () {
            addEspPricingModal.modal('show');
            addEspPricingModal.find('.form-control').each(function () {
                $(this).val(EMPTY_VALUE);
            });
        });

        btnAddEspPricing.on('click', function () {
            let range = addEspPricingModal.find('#range');
            let percent = addEspPricingModal.find('#percent');
            let freight = addEspPricingModal.find('#freight');

            let html = '<tr><td class="range">' + range.val() + '</td><td class="percent">' + percent.val() + '</td><td class="freight">' + freight.val() + '</td>' +
                '<td><i class="icon-im icon-im-pencil" style="cursor: pointer"></i><i class="icon-im icon-im-bin" style="cursor: pointer; margin-left: 10px"></i></td></tr>';
            tableEspPricing.append(html);

            handleFillDataEspPricing();
            addEspPricingModal.modal('hide');
        });
    };

    let handleDeleteEspPricing = function () {
        tableEspPricing.on('click', '.icon-im.icon-im-bin', function () {
            $(this).closest('tr').remove();
            handleFillDataEspPricing();
        });
    };

    let handleFillDataEspPricing = function () {
        let listEspPricing = [];
        tableEspPricing.find('tr').each(function () {
            let range = $(this).find('.range').html().trim();
            let percent = $(this).find('.percent').html().trim();
            let freight = $(this).find('.freight').html().trim();
            listEspPricing.push({range, percent, freight});
        });
        hiddenEspPricing.val(JSON.stringify(listEspPricing));
    };

    let loadAgainEspPricing = function () {
        loadEspPricingDefault.on('click', function () {
            ajaxSetup();
            let ajax = $.ajax({
                type: 'GET',
                url: urlLoadEspPricingDefault,
            });
            ajax.done(function (data) {
                let html = '';
                data.data.forEach(function (element) {
                    html += '<tr><td class="range">' + element.range + '</td><td class="percent">' + element.percent + '</td><td class="freight">' + element.freight + '</td>' +
                        '<td><i class="icon-im icon-im-pencil" style="cursor: pointer"></i><i class="icon-im icon-im-bin" style="cursor: pointer; margin-left: 10px"></i></td></tr>';
                });
                tableEspPricing.html(html);
            });
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

    return {
        // main function to initiate the module
        init: function () {
            handleToastrNotifs();

            handleAddSupplierPricing();
            handleDeleteSupplierPricing();

            handleAddEspPricing();
            handleDeleteEspPricing();
            loadAgainEspPricing();
        }
    }
})();

jQuery(document).ready(function () {
    Edit.init()
});
