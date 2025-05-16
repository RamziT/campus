$(document).ready(function () {
    var i = 1;
    $("#addSource").click(function () {
        i++;
        $("#dynamicform").append(
            '<tr id="row' +
                i +
                '"><th scope="row"><select name="structure_id" id="structure_id" class="selectpicker form-control w-80 " data-live-search="true" title="---Selectionner la structure---" required> @forelse ($structures as $structure) <option value="{{ $structure->id }}">{{ $structure->nom }}</option> @empty <option value="#">Aucune structure disponible</option> @endforelse</select></th><td><input type="number" name="somme[]" id="somme"class="form-control"placeholder="La somme financée" required /></td><td><button type="button"  id="' +
                i +
                '" class="btn btn-danger remove_row">-</button></td></tr>'
        );
    });
    $(document).on("click", ".remove_row", function () {
        var row_id = $(this).attr("id");
        $("#row" + row_id + "").remove();
    });
});
