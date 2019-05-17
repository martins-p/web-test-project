$("#select-product-type").change(function() {
    $("#hide-test").hide();
});

$("#save-button").click(function join_size_values () {
    var height = $("#furniture height").val();
    var width = $("#furniture width").val();
    var length = $("#furniture length").val();
    $("#furniture-size").val(height + "x" + width + "x" + length);
});



$("#select-product-type").change(function(){
    var selection = $("#select-product-type option:selected").text().toLowerCase().trimStart();
    $("#special-attribute-field").load("special_attributes/special_attributes.html #" + specialAttributeFields[selection]);
});

var specialAttributeFields = {
    "dvd-disc" : "dimensions-container",
    "furniture" : "size-container",
    "book" : "weight-container"
};