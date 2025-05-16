document.querySelectorAll("#rejeter").forEach((button) => {
    button.addEventListener("click", function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Êtes-vous sûr ?",
            text: "De vouloir rejeter ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Oui",
            cancelButtonText: "Non",
            input: "textarea",
            inputPlaceholder: "Entrez le commentaire",
            inputAttributes: {
                "aria-label": "Entrez un commentaire",
                required: true, // Ajout de l'attribut required
            },
            preConfirm: (comment) => {
                if (!comment) {
                    Swal.showValidationMessage(
                        "Veuillez entrer un commentaire."
                    );
                    return false;
                }
                return comment;
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const comment = result.value;
                const missionId = e.target.dataset.missionId; // Récupérer l'ID de la mission
                axios
                    .post("/rejeter/" + missionId, { comment: comment })
                    .then((response) => {
                        Swal.fire(
                            "Succès",
                            "La demande a bien été rejetée.",
                            "success"
                        );
                        // Rafraîchir la page ou effectuer d'autres actions
                    })
                    .catch((error) => {
                        Swal.fire(
                            "Erreur",
                            "Une erreur est survenue lors du rejet de la mission.",
                            "error"
                        );
                        console.error(error);
                    });
            }
        });
    });
});
