$("#save-button").click(function join_size_values () {
    var height = $("#furniture-height").val();
    var width = $("#furniture-width").val();
    var length = $("#furniture-length").val();
    $("#furniture-size").val(height + "x" + width + "x" + length);
});



$("#select-product-type").change(function(){
    var selection = $("#select-product-type option:selected").text().toLowerCase().trimStart();
    $("#special-attribute-field").load("special_attributes/special_attributes.html #" + specialAttributeFields[selection]);
});

var specialAttributeFields = {
    furniture : "dimensions-container",
    "dvd-disc" : "size-container",
    book : "weight-container",
};

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
            $("#delete-button").css("display", "block");
        } else {
            $("#delete-button").css("display", "none");
        };
}

$(".product-checkbox").on("click", function() {
    checkCheckedBoxes("mass-delete")
});