$("#save-button").click(function join_size_values() {
    var height = $("#furniture-height").val();
    var width = $("#furniture-width").val();
    var length = $("#furniture-length").val();
    $("#furniture-size").val(height + "x" + width + "x" + length);
});

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
    if ($("#" + form + " input[type=checkbox]:checked").length > 0) {
        $(".delete-button").css("display", "block");
    } else {
        $(".delete-button").css("display", "none");
    };
}

$(".product-checkbox").on("click", function () {
    let confirmDelete = confirm("Are you sure?");
    if (confirmDelete) {
        checkCheckedBoxes("mass-delete")}

});

var specialAtbSize = '<input type="hidden" name="special_attribute" value="Size"> Size <input type="text" name="special_attribute_value" required> GB<br>\
<p>Info about size.</p>';

var specialAtbWeight = '<input type="hidden" name="special_attribute" value="Weight"> Weight <input type="text" name="special_attribute_value" required> Kg<br>\
<p>Info about weight.</p>';

var specialAtbDimensions = '<input type="hidden" name="special_attribute" value="Dimensions">\
<table class="standard-table"><tr>\
    <td>Height</td>\
    <td><input type="number" id="furniture-height" required> cm</td>\
</tr>\
<tr>\
    <td>Width</td>\
    <td><input type="number" id="furniture-width" required> cm</td>\
</tr>\
<tr>\
    <td>Length</td>\
    <td><input type="number" id="furniture-length" required> cm</td>\
</tr></table>\
<input type="hidden" id="furniture-size" name="special_attribute_value">\
<p>Info about dimensions.</p>';

var productSpecAtbFields = {
    'dvd-disc': specialAtbSize,
    book: specialAtbWeight,
    furniture: specialAtbDimensions,
}