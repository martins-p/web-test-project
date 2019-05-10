$("#selected-product-type").change(function() {
    $("#hide-test").hide();
});

$("#save-button").click(function join_size_values () {
    var height = $("#furniture height").val();
    var width = $("#furniture width").val();
    var length = $("#furniture length").val();
    $("#furniture-size").val(height + "x" + width + "x" + length);
});

$("#select-product-type").select(function(){
    var selection = $("#select-product-type option:selected").text();
    $("#" + selection + "container").show();
});