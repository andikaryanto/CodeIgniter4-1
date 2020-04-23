
function ucFirst(string){
    return string.charAt(0).toUpperCase()+ string.slice(1)
}

$('input').on('focus', function() {
    var classes = this.className.split(" ");
    var input = this;
    $.each(classes, function(index, value) {
        if(value == "clearable"){
        var id = input.id;
        $("#"+id).val("");
        $("#M_"+ucFirst(id)+"_Id").val("");
        $("#T_"+ucFirst(id)+"_Id").val("");
        }
    });
});