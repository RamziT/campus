$(document).ready(function () {
    var i = 1;
    $("#addDecision").click(function () {
        i++;
        $("#dynamique").append(
            '<tr id="row' +
                i +
                '"> <td><input type="text" name="decisionPrise[]" id="decisionPrise" class="form-control" placeholder="Entrez la décision prise" required/><td><button type="button"  id="' +
                i +
                '" class="btn btn-danger remove_row">-</button></td></tr>'
        );
    });
    $(document).on("click", ".remove_row", function () {
        var row_id = $(this).attr("id");
        $("#row" + row_id + "").remove();
    });
});
