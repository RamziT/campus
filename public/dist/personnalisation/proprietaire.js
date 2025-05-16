const nomComboBox = document.getElementById("proprietaire");
const matriculeFields = document.getElementById("matricule-fields");

nomComboBox.addEventListener("change", function () {
    matriculeFields.style.display = "none";
    if (this.value === "0") {
        matriculeFields.style.display = "block";
    } else {
        matriculeFields.style.display = "none";
    }
});
