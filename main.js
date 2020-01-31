/* $("#save-button").click(function join_size_values() {
    var height = $("#furniture-height").val();
    var width = $("#furniture-width").val();
    var length = $("#furniture-length").val();
    $("#furniture-size").val(height + "x" + width + "x" + length);
}); */

//Dropdown function

$("#select-product-type").change(function () {
    var selection = $("#select-product-type option:selected").text().toLowerCase().trimStart();
    $("#special-attribute-field").html(productSpecAtbFields[selection]);
});





//Old dropdown function w/ conditional statements

/*$("#select-product-type").change(function () {
    var selection = $("#select-product-type option:selected").text().toLowerCase().trimStart();
    switch (selection) {
        case 'dvd-disc':
            $("#special-attribute-field").html(specialAtbSize);
            break;
        case 'book':
            $("#special-attribute-field").html(specialAtbWeight);
            break;
        case 'furniture':
            $("#special-attribute-field").html(specialAtbDimensions);
            break;
        default:
            $("#special-attribute-field").html('');
    }
});
*/

// $(".product-checkbox").change(function(){
//     console.log("Checked");
//     if ($(this).prop("checked")) {
//         $("#delete-button").show();
//     } else {
//         $("#delete-button").hide();
//     }
// });


function checkCheckedBoxes(form) {
    if ($("#product-grid input[type=checkbox]:checked").length > 0) {
        $(".delete-button").css("display", "block");
    } else {
        $(".delete-button").css("display", "none");
    };
}

$(".product-checkbox").on("click", function () {
    checkCheckedBoxes("mass-delete")
});

//Naming problem -> class=input-special_attribute_value

var specialAtbSize = '<input type="hidden" name="special_attribute" value="Size"> Size <input type="text" name="special_attribute_value" > GB <span class="input-special_attribute_value"></span><br>\
<p>Info about size.</p>';

var specialAtbWeight = '<input type="hidden" name="special_attribute" value="Weight"> Weight <input type="text" name="special_attribute_value" class="input-value" > Kg <span class="input-special_attribute_value"></span><br>\
<p>Info about weight.</p>';

var specialAtbDimensions = '<input type="hidden" name="special_attribute" value="Dimensions">\
<table class="standard-table"><tr>\
    <td>Height</td>\
    <td><input type="text" id="furniture-height" name="special_attribute_value[height]"> cm <span class="input-height"></td>\
</tr>\
<tr>\
    <td>Width</td>\
    <td><input type="text" id="furniture-width" name="special_attribute_value[width]"> cm <span class="input-width"></td>\
</tr>\
<tr>\
    <td>Length</td>\
    <td><input type="text" id="furniture-length" name="special_attribute_value[length]"> cm <span class="input-length"></td>\
</tr></table>\
<!-- <input type="hidden" id="furniture-size" class="input-value" name="special_attribute_value">-->\
<p>Info about dimensions.</p>';

var productSpecAtbFields = {
    'dvd-disc': specialAtbSize,
    book: specialAtbWeight,
    furniture: specialAtbDimensions,
}


//AJAX below


$(document).ready(function () {

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
                .done(function () {
                    $('#product-grid').load(' #product-grid > *');
                })
                .fail(function () {
                    // just in case posting your form failed
                    alert("Deletion was not successful.");
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
                    //alert("Product added");
                    showModal('Product succesfully added.');
                } else {
                    errOutput(response);
                }
            })

            .fail(function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Product could not be added.");

                console.log(errorThrown);
                //errOutput(errors);
            });

        function errOutput(response) { //Output errors if any

            // $('.error-message').remove(); //Remove existing messages
            messages = JSON.parse(response);
            if (messages['errType'] == 'validationErr') {
                //console.log(errors);
                jQuery.each(messages, function (key, value) {
                    if (value !== null && value !== '' && value !== 'errType') {
                        $('.input-' + key).after('<span class="error-message">' + value + '</span>');
                    }
                });
            } else if (messages['errType'] == 'duplicateFound') {
                showModal('Product already exists in database.');
            }
        };

        function showModal(message) {
            $('.modal-text').append(message);
            $('.modal').css('display', 'block');
            $('.close').click(function () {
                $('.modal').css('display', 'none');
                $('.modal-text').empty();
            });
            $(window).click(function () {
                $('.modal').css('display', 'none');
                $('.modal-text').empty();
            });
        };

    });

    /* $(window).click(function() {
        $('.modal').css('display', 'block');
        $('.modal-text').append('Product succesfully added.');
    }); */

});
