$.get("productsview.php").done(console.log("Checked view."));



$("#select-product-type").change(function () {
    var selection = $("#select-product-type option:selected").text().toLowerCase().trimStart();
    $("#special-attribute-field").html(productSpecAtbFields[selection]);
});

function checkCheckedBoxes(form) {
    if ($("#product-grid input[type=checkbox]:checked").length > 0) {
        $(".delete-button").show();
    } else {
        $(".delete-button").hide();
    };
}

$(document).on("click", ".product-checkbox", function () {
    checkCheckedBoxes("mass-delete");
});

//Naming problem -> class=input-special_attribute_value

var specialAtbSize = '<input type="hidden" name="special_attribute" value="Size"><span>Size</span> <input type="number" step="0.01" name="special_attribute_value" > GB <span class="input-special_attribute_value"></span><br>\
<p>Please specify size in GB. The value must be a valid number. Use "." as the decimal separator.</p>';



var specialAtbWeight = '<input type="hidden" name="special_attribute" value="Weight"><span>Weight</span><input type="number" step="0.01" name="special_attribute_value" class="input-value" > Kg <span class="input-special_attribute_value"></span><br>\
<p>Please specify weight in Kg. The value must be a valid number. Use "." as the decimal separator.</p>';

var specialAtbDimensions = '<input type="hidden" name="special_attribute" value="Dimensions">\
<table class="dimensions-table"><tr>\
    <td>Height</td>\
    <td><input type="number" step="0.1" id="furniture-height" name="special_attribute_value[height]"> cm <span class="input-height"></td>\
</tr>\
<tr>\
    <td>Width</td>\
    <td><input type="number" step="0.1" id="furniture-width" name="special_attribute_value[width]"> cm <span class="input-width"></td>\
</tr>\
<tr>\
    <td>Length</td>\
    <td><input type="number" step="0.01" id="furniture-length" name="special_attribute_value[length]"> cm <span class="input-length"></td>\
</tr></table>\
<!-- <input type="hidden" id="furniture-size" class="input-value" name="special_attribute_value">-->\
<p>Please specify Dimensions in cm. The value must be a valid number. Use "." as the decimal separator.</p>';

var productSpecAtbFields = {
    'dvd-disc': specialAtbSize,
    book: specialAtbWeight,
    furniture: specialAtbDimensions,
}


//AJAX below

$(document).ready(function () {
    console.log('Document loaded.');
    //Product delete method

    $('#productCardForm').submit(function () {

        // Prevent the form from submitting the default way
        event.preventDefault();

        if (confirm("Are you sure you want to delete? This action cannnot be undone.")) {
            var formData = $(this).serializeArray();
            formData.push({ name: 'massDelBtn', value: 'delete' });

            $.ajax({
                type: 'POST',
                url: 'includes/productscontr.php',
                data: formData
            })
                .done(function (response) {
                    console.log(response);
                    if (response == "") {
                        $('#product-grid').load(' #product-grid > *');
                        $(".delete-button").hide();

                        showModal('Product(s) succesfully deleted');
                    } else {
                        errOutput(response);
                    }
                })
                .fail(function () {
                    // just in case posting your form failed
                    showModal('Error: product could not be deleted'); //This is not enough
                });
        }
    });


    //Product add method
    $('#addProdForm').submit(function () {

        // Prevent the form from submitting the default way
        event.preventDefault();

        $('.error-message').remove();
        var formData = $(this).serializeArray(); //Why use serializearray?
        formData.push({ name: 'addProduct', value: 'add' });
        //formData = JSON.stringify(formData);
        var errors = "";

        $.ajax({
            type: 'POST',
            //dataType: 'JSON',
            url: 'includes/productscontr.php',
            data: formData,
            //contentType: 'application/json'
        })
            .done(function (response) {

                //Reset form if submitted succesfully 
                if (response == "") {
                    $('#addProdForm').each(function () {
                        this.reset();
                    });
                    $(':input', '#select-product-type').removeAttr('selected');
                    $('#special-attribute-field').empty();
                    showModal('Success! Product has been added');
                } else {
                    errOutput(response);
                }
            })

            .fail(function () {
                showModal("Error: product could not be added");
                //errOutput(errors);
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

    function errOutput(response) { //Output errors if any

        // $('.error-message').remove(); //Remove existing messages
        messages = JSON.parse(response);
        if (messages['errType'] == 'validationError') {
            //console.log(errors);
            jQuery.each(messages, function (key, value) {
                if (value !== null && value !== '' && key !== 'errType') {
                    $('.input-' + key).after('<span class="error-message">' + value + '</span>');
                }
            });
        } else if (messages['errType'] == 'modalError') {
            showModal(messages['errorMsg']);
        }
    };
});


