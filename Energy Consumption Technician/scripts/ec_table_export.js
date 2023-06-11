function downloadGeneralECExcelTable() {
    var tables = ['ec_param_general_data', 'ec_param_acu_data', 'ec_param_outlet_data','ec_param_lights_data', 'ec_param_others_data'];
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
        link.download = 'general_parameter_data.xlsx';
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

function downloadACUExcelTable() {
    var tables = ['ec_param_acu_data'];
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
        link.download = 'acu_parameter_data.xlsx';
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

function downloadCOExcelTable() {
    var tables = ['ec_param_outlet_data'];
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
        link.download = 'outlet_parameter_data.xlsx';
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

function downloadUtilExcelTable() {
    var tables = ['ec_param_util_data'];
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
        link.download = 'utility_parameter_data.xlsx';
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

function downloadLightsExcelTable() {
    var tables = ['ec_param_lights_data'];
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
        link.download = 'lights_parameter_data.xlsx';
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

function downloadOthersExcelTable() {
    var tables = ['ec_param_others_data'];
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
        link.download = 'others_parameter_data.xlsx';
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