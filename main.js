//Method that changes special attribute DIV in add_page.php
$("#select-product-type").change(function () {
    var selection = $("#select-product-type option:selected").text().toLowerCase().trimStart();
    $("#special-attribute-field").html(productSpecAtbFields[selection]);
});


//Special attribute field DIVs
var specialAtbSize = '<input type="hidden" name="special_attribute" value="Size"><span>Size</span> <input type="number" step="0.01" name="special_attribute_value" > GB <span class="input_special_attribute_value"></span><br>\
<p>Please specify size in GB. The value must be a valid number. Use "." as the decimal separator.</p>';

var specialAtbWeight = '<input type="hidden" name="special_attribute" value="Weight"><span>Weight</span><input type="number" step="0.01" name="special_attribute_value" class="input_value" > Kg <span class="input_special_attribute_value"></span><br>\
<p>Please specify weight in Kg. The value must be a valid number. Use "." as the decimal separator.</p>';

var specialAtbDimensions = '<input type="hidden" name="special_attribute" value="Dimensions">\
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

var specialAtbDefault = '<input type="hidden" name="special_attribute" value="">\
<input type="hidden" name="special_attribute_value" value="">';

//Special attribute DIVs bound to product type as key
var productSpecAtbFields = {
    default: specialAtbDefault,
    'dvd-disc': specialAtbSize,
    book: specialAtbWeight,
    furniture: specialAtbDimensions,
}

//Show/hide Delete button based on checkbox status
$(document).on("click", ".product-checkbox", function () {
    if ($("#product-grid input[type=checkbox]:checked").length > 0) {
        $(".delete-button").show();
    } else {
        $(".delete-button").hide();
    };
});

$(document).ready(function () {

    //Product deletion method
    $('#productCardForm').submit(function () {

        // Prevent form from submitting the default way
        event.preventDefault();

        if (confirm("Are you sure you want to delete? This action cannnot be undone.")) {

            //Get form input data
            var formData = $(this).serializeArray();
            formData.push({ name: 'btnAction', value: 'delete' });

            $.ajax({
                method: 'POST',
                url: 'includes/productscontr.php',
                data: formData,
            })
                .done(function (response) {
                    if (!$.trim(response)) {
                        //Form submitted successfully
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


    //Product add method
    $('#addProductForm').submit(function () {

        // Prevent the form from submitting the default way
        event.preventDefault();

        //Clear input error messages
        $('.error-message').remove();

        //Get form input data
        var formData = $(this).serializeArray();
        formData.push({ name: 'btnAction', value: 'add' });

        $.ajax({
            type: 'POST',
            url: 'includes/productscontr.php',
            data: formData,
        })
            .done(function (response) {

                //Reset form if submitted succesfully 
                if (!$.trim(response)) {
                    //Form submitted successfully
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
                    $('.input_' + key).after('<span class="error-message">' + value + '</span>');
                }
            });
        }
    };
});


