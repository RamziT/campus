const searchInput = document.getElementById("searchInput");
const tableRows = document.querySelectorAll("table tbody tr");
const noResultsMessage = document.getElementById("noResultsMessage");
if (searchInput) {
    searchInput.addEventListener("keyup", function (event) {
        const searchText = event.target.value.toLowerCase();
        let resultsFound = false;

        tableRows.forEach(function (row) {
            const rowData = row.textContent.toLowerCase();

            if (rowData.includes(searchText)) {
                row.style.display = "";
                resultsFound = true;
            } else {
                row.style.display = "none";
            }
        });

        if (resultsFound) {
            noResultsMessage.style.display = "none";
        } else {
            noResultsMessage.style.display = "block";
        }
    });
}

