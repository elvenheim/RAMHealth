function sortAQSensorTable(columnIndex) {
    let table, rows, switching, i, x, y, shouldSwitch, sortIndicator;
    table = document.querySelector(".air-quality-sensors-table");
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

function sortDeleteTable(columnIndex) {
let table, rows, switching, i, x, y, shouldSwitch, sortIndicator;
table = document.querySelector(".air-quality-deleted-sensors-table");
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

function sortAQGeneralTable(columnIndex) {
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

function sortAQPMTable(columnIndex) {
    let table, rows, switching, i, x, y, shouldSwitch, sortIndicator;
    table = document.querySelector(".air-particulate-table");
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

function sortAQGasTable(columnIndex) {
    let table, rows, switching, i, x, y, shouldSwitch, sortIndicator;
    table = document.querySelector(".gas-level-table");
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

function sortAQHumidityTable(columnIndex) {
    let table, rows, switching, i, x, y, shouldSwitch, sortIndicator;
    table = document.querySelector(".relative-humidity-table");
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

function sortAQOutTempTable(columnIndex) {
    let table, rows, switching, i, x, y, shouldSwitch, sortIndicator;
    table = document.querySelector(".outdoor-temperature-table");
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

function sortAQInTempTable(columnIndex) {
    let table, rows, switching, i, x, y, shouldSwitch, sortIndicator;
    table = document.querySelector(".indoor-temperature-table");
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