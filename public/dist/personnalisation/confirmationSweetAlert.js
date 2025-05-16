document.querySelectorAll("#confirmation").forEach((button) => {
    button.addEventListener("click", function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Êtes-vous sûr ?",
            text: "De vouloir supprimer?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Oui,Supprimer!",
            cancelButtonText: "Non",
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest("form").submit();
            }
        });
    });
});
