let Index = (function () {
    let checkboxColor = $('.checkbox-color');
    let checkboxSize = $('.checkbox-size');
    let hiddenCheckBoxColor = $('#hiddenCheckBoxColor');
    let hiddenCheckBoxSize = $('#hiddenCheckBoxSize');

    let handleCheckBoxColor = function () {
        checkboxColor.on('change', function () {
            let listColor = [];
            checkboxColor.each(function () {
                if($(this).is(':checked')) {
                    listColor.push(parseInt($(this).val()));
                }
            });
            hiddenCheckBoxColor.val(JSON.stringify(listColor));
        });
    };

    let handleCheckBoxSize = function () {
        checkboxSize.on('change', function () {
            let listSize = [];
            checkboxSize.each(function () {
                if($(this).is(':checked')) {
                    listSize.push(parseInt($(this).val()));
                }
            });
            hiddenCheckBoxSize.val(JSON.stringify(listSize));
        });
    };

    return {
        // main function to initiate the module
        init: function () {
            handleCheckBoxColor();
            handleCheckBoxSize();
        }
    }
})();

jQuery(document).ready(function () {
    Index.init()
});
