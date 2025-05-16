$(document).ready(function () {
    var i = 1;
    $("#addP").click(function () {
        i++;
        $("#formDynamic").append(
            '<tr id="row' +
                i +
                '"><th scope="row"><select name="participant_id[]"class="selectpicker form-control w-80" data-live-search="true" title="---Selectionner la structure---">@forelse ($personnels as $personnel)<option value="{{ $personnel->id }}">{{ Str::upper($personnel->nom) . \' \' . $personnel->prenom }}</option>@empty<option value="#">Aucun personnel disponible</option>@endforelse</select> @error(\'structure_id\')<span class="text-danger">{{ $message }}</span>@enderror</th><td><button type="button"  id="' +
                i +
                '" class="btn btn-danger remove_row">-</button></td></tr>'
        );
        $(".selectpicker").selectpicker("refresh");
    });
    $(document).on("click", ".remove_row", function () {
        var row_id = $(this).attr("id");
        $("#row" + row_id + "").remove();
        $(".selectpicker").selectpicker("refresh"); // Initialise Selectpicker après la suppression des éléments
    });
});
