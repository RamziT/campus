$(document).ready(function () {
    var i = 1;
    $("#addObj").click(function () {
        i++;
        $("#dynamic").append(
            '<tr id="row' +
                i +
                '"><td><input type="text" name="objectifSpecifique[]" id="objectifSpecifique" placeholder="Entrez l\'objectif ici" class="form-control" required/></td><td><button type="button"  id="' +
                i +
                '" class="btn btn-danger remove_row">-</button></td></tr>'
        );
    });
    $(document).on("click", ".remove_row", function () {
        var row_id = $(this).attr("id");
        $("#row" + row_id + "").remove();
    });
});
