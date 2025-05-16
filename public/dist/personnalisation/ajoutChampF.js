const nomFields = document.getElementById("nomMission");
const atelierField = document.getElementById("atelier-field");
const auditField = document.getElementById("audit-field");
const conferenceField = document.getElementById("conference-field");
const seminaireField = document.getElementById("seminaire-field");
const interventionField = document.getElementById("intervention-field");
const controleField = document.getElementById("controle-field");
const reunionField = document.getElementById("reunion-field");
nomField.addEventListener("change", function () {
    atelierField.style.display = "none";
    auditField.style.display = "none";
    seminaireField.style.display = "none";
    interventionField.style.display = "none";
    controleField.style.display = "none";
    conferenceField.style.display = "none";
    reunionField.style.display = "none";
    if (this.value === "atélier") {
        atelierField.style.display = "block";
        auditField.style.display = "none";
        seminaireField.style.display = "none";
        interventionField.style.display = "none";
        controleField.style.display = "none";
        conferenceField.style.display = "none";
        reunionField.style.display = "none";
    } else if (this.value === "audit") {
        auditField.style.display = "block";
        atelierField.style.display = "none";
        seminaireField.style.display = "none";
        interventionField.style.display = "none";
        controleField.style.display = "none";
        conferenceField.style.display = "none";
        reunionField.style.display = "none";
    } else if (this.value === "conférence") {
        conferenceField.style.display = "block";
        atelierField.style.display = "none";
        auditField.style.display = "none";
        seminaireField.style.display = "none";
        interventionField.style.display = "none";
        controleField.style.display = "none";
        reunionField.style.display = "none";
    } else if (this.value === "séminaire") {
        seminaireField.style.display = "block";
        atelierField.style.display = "none";
        auditField.style.display = "none";
        interventionField.style.display = "none";
        controleField.style.display = "none";
        conferenceField.style.display = "none";
        reunionField.style.display = "none";
    } else if (this.value === "intervention") {
        interventionField.style.display = "block";
        atelierField.style.display = "none";
        auditField.style.display = "none";
        seminaireField.style.display = "none";
        controleField.style.display = "none";
        conferenceField.style.display = "none";
        reunionField.style.display = "none";
    } else if (this.value === "contrôle") {
        controleField.style.display = "block";
        atelierField.style.display = "none";
        auditField.style.display = "none";
        seminaireField.style.display = "none";
        interventionField.style.display = "none";
        conferenceField.style.display = "none";
        reunionField.style.display = "none";
    } else if (this.value === "reunion") {
        reunionField.style.display = "block";
        atelierField.style.display = "none";
        auditField.style.display = "none";
        seminaireField.style.display = "none";
        interventionField.style.display = "none";
        controleField.style.display = "none";
        conferenceField.style.display = "none";
    } else if (this.value === "représentation") {
        atelierField.style.display = "none";
        auditField.style.display = "none";
        seminaireField.style.display = "none";
        interventionField.style.display = "none";
        controleField.style.display = "none";
        conferenceField.style.display = "none";
        reunionField.style.display = "none";
    } else {
        atelierField.style.display = "none";
        auditField.style.display = "none";
        seminaireField.style.display = "none";
        interventionField.style.display = "none";
        controleField.style.display = "none";
        conferenceField.style.display = "none";
        reunionField.style.display = "none";
    }
});

function updateFields() {
    atelierField.style.display = "none";
    auditField.style.display = "none";
    seminaireField.style.display = "none";
    interventionField.style.display = "none";
    controleField.style.display = "none";
    conferenceField.style.display = "none";
    reunionField.style.display = "none";
    const value = nomField.value;
    if (value === "atélier") {
        atelierField.style.display = "block";
        //reunion
        var modeSuivi = document.getElementById("modeSuivi");
        var ordreJour = document.getElementById("ordreJour");
        var responsable = document.getElementById("responsable");
        //controle
        var typeAC = document.getElementById("typeACC");
        var structure_id = document.getElementById("structure_idC");
        //intervention
        var nature = document.getElementById("nature");
        var sujet = document.getElementById("sujet");
        //seminaire
        var themeS = document.getElementById("themeS");
        var nomAnimateurS = document.getElementById("nomAnimateurS");
        //conference
        var themeC = document.getElementById("themeC");
        var nomConferencier = document.getElementById("nomConferencier");
        //audit
        var typeACC = document.getElementById("typeAC");
        var structure_idA = document.getElementById("structure_id");
        typeACC.value = "";
        structure_idA.value = "";
        modeSuivi.value = "";
        ordreJour.value = "";
        responsable.value = "";
        typeAC.value = "";
        structure_id.value = "";
        nature.value = "";
        sujet.value = "";
        themeS.value = "";
        nomAnimateurS.value = "";
        themeC.value = "";
        nomConferencier.value = "";
    } else if (value === "audit") {
        auditField.style.display = "block";
        //atelier
        var theme = document.getElementById("theme");
        var nomDirigeant = document.getElementById("nomDirigeant");
        //reunion
        var modeSuivi = document.getElementById("modeSuivi");
        var ordreJour = document.getElementById("ordreJour");
        var responsable = document.getElementById("responsable");
        //controle
        var typeAC = document.getElementById("typeACC");
        var structure_id = document.getElementById("structure_idC");
        //intervention
        var nature = document.getElementById("nature");
        var sujet = document.getElementById("sujet");
        //seminaire
        var themeS = document.getElementById("themeS");
        var nomAnimateurS = document.getElementById("nomAnimateurS");
        //conference
        var themeC = document.getElementById("themeC");
        var nomConferencier = document.getElementById("nomConferencier");
        theme.value = "";
        nomDirigeant.value = "";
        modeSuivi.value = "";
        ordreJour.value = "";
        responsable.value = "";
        typeAC.value = "";
        structure_id.value = "";
        nature.value = "";
        sujet.value = "";
        themeS.value = "";
        nomAnimateurS.value = "";
        themeC.value = "";
        nomConferencier.value = "";
    } else if (value === "conférence") {
        conferenceField.style.display = "block";
        //atelier
        var theme = document.getElementById("theme");
        var nomDirigeant = document.getElementById("nomDirigeant");
        //reunion
        var modeSuivi = document.getElementById("modeSuivi");
        var ordreJour = document.getElementById("ordreJour");
        var responsable = document.getElementById("responsable");
        //controle
        var typeAC = document.getElementById("typeACC");
        var structure_id = document.getElementById("structure_idC");
        //intervention
        var nature = document.getElementById("nature");
        var sujet = document.getElementById("sujet");
        //seminaire
        var themeS = document.getElementById("themeS");
        var nomAnimateurS = document.getElementById("nomAnimateurS");
        //audit
        var typeACC = document.getElementById("typeAC");
        var structure_idA = document.getElementById("structure_id");
        theme.value = "";
        nomDirigeant.value = "";
        typeACC.value = "";
        structure_idA.value = "";
        modeSuivi.value = "";
        ordreJour.value = "";
        responsable.value = "";
        typeAC.value = "";
        structure_id.value = "";
        nature.value = "";
        sujet.value = "";
        themeS.value = "";
        nomAnimateurS.value = "";
    } else if (value === "séminaire") {
        seminaireField.style.display = "block";
        //atelier
        var theme = document.getElementById("theme");
        var nomDirigeant = document.getElementById("nomDirigeant");
        //reunion
        var modeSuivi = document.getElementById("modeSuivi");
        var ordreJour = document.getElementById("ordreJour");
        var responsable = document.getElementById("responsable");
        //controle
        var typeAC = document.getElementById("typeACC");
        var structure_id = document.getElementById("structure_idC");
        //intervention
        var nature = document.getElementById("nature");
        var sujet = document.getElementById("sujet");
        //audit
        var typeACC = document.getElementById("typeAC");
        var structure_idA = document.getElementById("structure_id");
        //conference
        var themeC = document.getElementById("themeC");
        var nomConferencier = document.getElementById("nomConferencier");
        themeC.value = "";
        nomConferencier.value = "";
        theme.value = "";
        nomDirigeant.value = "";
        typeACC.value = "";
        structure_idA.value = "";
        modeSuivi.value = "";
        ordreJour.value = "";
        responsable.value = "";
        typeAC.value = "";
        structure_id.value = "";
        nature.value = "";
        sujet.value = "";
    } else if (value === "intervention") {
        interventionField.style.display = "block";
        //seminaire
        var themeS = document.getElementById("themeS");
        var nomAnimateurS = document.getElementById("nomAnimateurS");
        //atelier
        var theme = document.getElementById("theme");
        var nomDirigeant = document.getElementById("nomDirigeant");
        //reunion
        var modeSuivi = document.getElementById("modeSuivi");
        var ordreJour = document.getElementById("ordreJour");
        var responsable = document.getElementById("responsable");
        //controle
        var typeAC = document.getElementById("typeACC");
        var structure_id = document.getElementById("structure_idC");
        //audit
        var typeACC = document.getElementById("typeAC");
        var structure_idA = document.getElementById("structure_id");
        //conference
        var themeC = document.getElementById("themeC");
        var nomConferencier = document.getElementById("nomConferencier");
        themeC.value = "";
        nomConferencier.value = "";
        theme.value = "";
        nomDirigeant.value = "";
        typeACC.value = "";
        structure_idA.value = "";
        modeSuivi.value = "";
        ordreJour.value = "";
        responsable.value = "";
        typeAC.value = "";
        structure_id.value = "";
        themeS.value = "";
        nomAnimateurS.value = "";
    } else if (value === "contrôle") {
        controleField.style.display = "block";
        //seminaire
        var themeS = document.getElementById("themeS");
        var nomAnimateurS = document.getElementById("nomAnimateurS");
        //atelier
        var theme = document.getElementById("theme");
        var nomDirigeant = document.getElementById("nomDirigeant");
        //reunion
        var modeSuivi = document.getElementById("modeSuivi");
        var ordreJour = document.getElementById("ordreJour");
        var responsable = document.getElementById("responsable");
        //intervention
        var nature = document.getElementById("nature");
        var sujet = document.getElementById("sujet");
        //audit
        var typeAC = document.getElementById("typeAC");
        var structure_idA = document.getElementById("structure_id");
        //conference
        var themeC = document.getElementById("themeC");
        var nomConferencier = document.getElementById("nomConferencier");
        themeC.value = "";
        nomConferencier.value = "";
        theme.value = "";
        nomDirigeant.value = "";
        typeAC.value = "";
        structure_idA.value = "";
        modeSuivi.value = "";
        ordreJour.value = "";
        responsable.value = "";
        nature.value = "";
        sujet.value = "";
        themeS.value = "";
        nomAnimateurS.value = "";
    } else if (value === "reunion") {
        reunionField.style.display = "block";
        //seminaire
        var themeS = document.getElementById("themeS");
        var nomAnimateurS = document.getElementById("nomAnimateurS");
        //atelier
        var theme = document.getElementById("theme");
        var nomDirigeant = document.getElementById("nomDirigeant");
        //controle
        var typeAC = document.getElementById("typeACC");
        var structure_id = document.getElementById("structure_idC");
        //intervention
        var nature = document.getElementById("nature");
        var sujet = document.getElementById("sujet");
        //audit
        var typeACC = document.getElementById("typeAC");
        var structure_idA = document.getElementById("structure_id");
        //conference
        var themeC = document.getElementById("themeC");
        var nomConferencier = document.getElementById("nomConferencier");
        themeC.value = "";
        nomConferencier.value = "";
        theme.value = "";
        nomDirigeant.value = "";
        typeACC.value = "";
        structure_idA.value = "";
        typeAC.value = "";
        structure_id.value = "";
        nature.value = "";
        sujet.value = "";
        themeS.value = "";
        nomAnimateurS.value = "";
    } else {
        atelierField.style.display = "none";
        auditField.style.display = "none";
        seminaireField.style.display = "none";
        interventionField.style.display = "none";
        controleField.style.display = "none";
        conferenceField.style.display = "none";
        reunionField.style.display = "none";
    }
}
nomField.addEventListener("change", updateFields);
window.onload = updateFields;
