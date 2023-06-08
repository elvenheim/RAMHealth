function sortECGeneralTable(columnIndex) {
    let table, rows, switching, i, x, y, shouldSwitch, sortIndicator;
    table = document.querySelector(".air-quality-table");
    switching = true;
    sortIndicator = document.querySelector(
        `th:nth-child(${columnIndex + 1}) .sort-indicator`
    );
  
    let sortOrder = sortIndicator.getAttribute("data-sort-order") || "asc";
    
    while (switching) {
        switching = false;
        rows = table.rows;
        
        for (i = 1; i < rows.length - 1; i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("td")[columnIndex];
            y = rows[i + 1].getElementsByTagName("td")[columnIndex];
  
            let xValue = x.innerHTML.toLowerCase();
            let yValue = y.innerHTML.toLowerCase();
            
            if (sortOrder === "asc") {
                if (xValue > yValue) {
                    shouldSwitch = true;
                    break;
                }
            } else {
                if (xValue < yValue) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
    
    // Toggle the sorting order
    if (sortOrder === "asc") {
        sortIndicator.setAttribute("data-sort-order", "desc");
        sortIndicator.innerHTML = "&#x25BC;";
    } else {
        sortIndicator.setAttribute("data-sort-order", "asc");
        sortIndicator.innerHTML = "&#x25B2;";
    }
}