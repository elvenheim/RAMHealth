function downloadAQExcelTables() {
    var tables = ['aq_gas_level', 'aq_indoor_temperature', 'aq_outdoor_temperature', 'aq_particulate_matter', 'aq_relative_humidity'];
    var workbook = XLSX.utils.book_new();

    // Create a recursive function to fetch and add each table as a separate sheet in the workbook
    function fetchTableData(index) {
    if (index >= tables.length) {
        // All table data fetched, proceed to download the Excel file
        var excelBuffer = XLSX.write(workbook, { type: 'array' });
        var blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        var url = URL.createObjectURL(blob);
        var link = document.createElement('a');
        link.href = url;
        link.download = 'air_quality_tables.xlsx';
        link.click();
        return;
    }

    var tableName = tables[index];

      // Create an XMLHTTPRequest to get the Excel file from the server
    var xhr = new XMLHttpRequest();
    xhr.open('GET', window.location.origin + '/RAMHealth/scripts/export_script.php?table=' + tableName, true);
    xhr.responseType = 'arraybuffer';
    xhr.onload = function(e) {
        if (this.status == 200) {
        var arraybuffer = this.response;
        var data = new Uint8Array(arraybuffer);
        var workbookData = XLSX.read(data, { type: 'array' });
        var worksheet = workbookData.Sheets[workbookData.SheetNames[0]];
        XLSX.utils.book_append_sheet(workbook, worksheet, tableName);
          // Proceed to fetch the next table data
        fetchTableData(index + 1);
        }
    };
    xhr.send();
    }

    // Start fetching the table data from the first table
    fetchTableData(0);
}

function downloadECExcelTables() {
    var tables = ['ec_param_acu_data', 'ec_param_outlet_data', 'ec_param_util_data', 'ec_param_lights_data', 'ec_param_others_data'];
    var workbook = XLSX.utils.book_new();

    // Create a recursive function to fetch and add each table as a separate sheet in the workbook
    function fetchTableData(index) {
    if (index >= tables.length) {
        // All table data fetched, proceed to download the Excel file
        var excelBuffer = XLSX.write(workbook, { type: 'array' });
        var blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        var url = URL.createObjectURL(blob);
        var link = document.createElement('a');
        link.href = url;
        link.download = 'air_quality_tables.xlsx';
        link.click();
        return;
    }

    var tableName = tables[index];

      // Create an XMLHTTPRequest to get the Excel file from the server
    var xhr = new XMLHttpRequest();
    xhr.open('GET', window.location.origin + '/RAMHealth/scripts/export_script.php?table=' + tableName, true);
    xhr.responseType = 'arraybuffer';
    xhr.onload = function(e) {
        if (this.status == 200) {
        var arraybuffer = this.response;
        var data = new Uint8Array(arraybuffer);
        var workbookData = XLSX.read(data, { type: 'array' });
        var worksheet = workbookData.Sheets[workbookData.SheetNames[0]];
        XLSX.utils.book_append_sheet(workbook, worksheet, tableName);
          // Proceed to fetch the next table data
        fetchTableData(index + 1);
        }
    };
    xhr.send();
    }

    // Start fetching the table data from the first table
    fetchTableData(0);
}