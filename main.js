
$("#select-product-type").change(function () { //Changes form field for special attribute in add_page.php
    var selection = $("#select-product-type option:selected").text().toLowerCase().trimStart();
    $("#special-attribute-field").html(productSpecAtbFields[selection]);
});


//Special attribute field DIVs 
var sizeAttrb = '<input type="hidden" name="special_attribute" value="Size"><span>Size</span> <input type="number" step="0.01" name="special_attribute_value" > GB <span class="input_special_attribute_value"></span><br>\
<p>Please specify size in GB. The value must be a valid number. Use "." as the decimal separator.</p>';

var weightAttrb = '<input type="hidden" name="special_attribute" value="Weight"><span>Weight</span><input type="number" step="0.01" name="special_attribute_value" class="input_value" > Kg <span class="input_special_attribute_value"></span><br>\
<p>Please specify weight in Kg. The value must be a valid number. Use "." as the decimal separator.</p>';

var dimensionsAttrb = '<input type="hidden" name="special_attribute" value="Dimensions">\
<table class="dimensions-table"><tr>\
    <td>Height</td>\
    <td><input type="number" step="0.1" id="furniture-height" name="special_attribute_value[height]"> cm <span class="input_height"></td>\
</tr>\
<tr>\
    <td>Width</td>\
    <td><input type="number" step="0.1" id="furniture-width" name="special_attribute_value[width]"> cm <span class="input_width"></td>\
</tr>\
<tr>\
    <td>Length</td>\
    <td><input type="number" step="0.01" id="furniture-length" name="special_attribute_value[length]"> cm <span class="input_length"></td>\
</tr></table>\
<p>Please specify Dimensions in cm. The value must be a valid number. Use "." as the decimal separator.</p>';

var defaultAttrb = '<input type="hidden" name="special_attribute" value="">\
<input type="hidden" name="special_attribute_value" value="">';

//Special attribute DIVs bound to product types
var productSpecAtbFields = {
    default: defaultAttrb,
    'dvd-disc': sizeAttrb,
    book: weightAttrb,
    furniture: dimensionsAttrb,
}

//Show/hide Delete button according to checkbox status
$(document).on("click", ".product-checkbox", function () {
    if ($("#product-grid input[type=checkbox]:checked").length > 0) {
        $(".delete-button").show();
    } else {
        $(".delete-button").hide();
    };
});

$(document).ready(function () { 

    $('#productCardForm').submit(function () { //Product deletion method

        // Prevent form from submitting the default way
        event.preventDefault();

        if (confirm("Are you sure you want to delete? This action cannnot be undone.")) {

            var formData = $(this).serializeArray();
            formData.push({ name: 'btnAction', value: 'delete' });

            $.ajax({
                method: 'POST',
                url: 'includes/productcontr.php',
                data: formData,
            })
                .done(function (response) {
                    if (!$.trim(response)) {
                        $('#product-grid').load(' #product-grid > *');
                        $(".delete-button").hide();
                        showModal('Product(s) succesfully deleted');
                    } else {
                        messages = JSON.parse(response);
                        showModal(messages['errorMsg']);
                    }
                })
                .fail(function () {
                    showModal('Product could not be deleted.');
                });
        }
    });

    $('#addProductForm').submit(function () { //Product add method

        // Prevent the form from submitting the default way
        event.preventDefault();

        $('.input-error-message').remove();

        var formData = $(this).serializeArray();
        formData.push({ name: 'btnAction', value: 'add' });

        $.ajax({
            type: 'POST',
            url: 'includes/productcontr.php',
            data: formData,
        })
            .done(function (response) {

                if (!$.trim(response)) {
                    $('#addProductForm').each(function () { //Reset form fields
                        this.reset();
                    });
                    $(':input', '#select-product-type').removeAttr('selected'); //Reset dropdown
                    $('#special-attribute-field').empty();
                    $('#special-attribute-field').html(productSpecAtbFields['default']); //Reset special attribute field

                    showModal('Success! Product has been added');
                } else {
                    console.log(response);
                    messages = JSON.parse(response);
                    if (messages['errType'] == 'validationError') {
                        validationErrOutput(messages);
                    } else if (messages['errType'] == 'modalError') {
                        showModal(messages['errorMsg']);
                    }
                }
            })
            .fail(function () {
                showModal("Error: product could not be added.");
            });
    });

    window.showModal = function (message) {
        $('.modal-text').append(message);
        $('.modal').css('display', 'block');
        $('.close').click(function () {
            $('.modal').css('display', 'none');
            $('.modal-text').empty();
        });
        $(document).click(function (e) {
            var targetElement = $('.modal');
            if (targetElement.is(e.target)) {
                $('.modal').css('display', 'none');
                $('.modal-text').empty();
            }

        });
    };

    function validationErrOutput(response) {
        if (messages['errType'] == 'validationError') {
            //Display validation errors next to respective form fields
            jQuery.each(messages, function (key, value) {
                if (value !== null && value !== '' && key !== 'errType') {
                    $('.input_' + key).after('<span class="input-error-message">' + value + '</span>');
                }
            });
        }
    };
});


