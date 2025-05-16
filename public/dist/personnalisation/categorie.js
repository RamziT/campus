const nomComboBox1 = document.getElementById("categorie");
const repFields = document.getElementById("rep-fields");
const nomEvenement = document.getElementById("nomEvenement");
const representant = document.getElementById("representant");
const positionRepresente = document.getElementById("positionRepresente");
const description = document.getElementById("descriptionR");
nomComboBox1.addEventListener("change", function () {
    repFields.style.display = "none";
    if (this.value === "1") {
        repFields.style.display = "block";
        nomEvenement = document.getElementById("nomEvenement");
        nomEvenement.required = true;
        representant.required = true;
        positionRepresente.required = true;
        description.required = true;
    } else {
        repFields.style.display = "none";
        nomEvenement.required = false;
        representant.required = false;
        positionRepresente.required = false;
        description.required = false;
    }
});
