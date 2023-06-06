function downloadAQExcelTables() {
    var tables = ['air_quality_table', 'aq_gas_level', 'aq_indoor_temperature', 'aq_outdoor_temperature', 'aq_particulate_matter', 'aq_relative_humidity'];
  
    // Create an empty array to store the worksheet data
    var mergedWorksheetData = [];
  
    // Create a recursive function to fetch and merge the worksheet data for each table
    function fetchTableData(index) {
      if (index >= tables.length) {
        // All table data fetched, proceed to download the merged Excel file
        var worksheet = XLSX.utils.aoa_to_sheet(mergedWorksheetData);
        
        // Apply bold font style to the header row
        var headerRange = XLSX.utils.decode_range(worksheet['!ref']);
        for (var col = headerRange.s.c; col <= headerRange.e.c; col++) {
          var headerCell = XLSX.utils.encode_cell({ r: headerRange.s.r, c: col });
          var headerCellStyle = worksheet[headerCell].s || {};
          headerCellStyle.font = { bold: true };
          worksheet[headerCell].s = headerCellStyle;
        }
        
        var workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Merged Tables');
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
          var workbook = XLSX.read(data, { type: 'array' });
          var worksheet = workbook.Sheets[workbook.SheetNames[0]];
          var worksheetData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
          // Append the fetched worksheet data to the merged worksheet data array
          mergedWorksheetData = mergedWorksheetData.concat(worksheetData);
          // Proceed to fetch the next table data
          fetchTableData(index + 1);
        }
      };
      xhr.send();
    }
  
    // Start fetching the table data from the first table
    fetchTableData(0);
}

function downloadAPMExcelTable() {
  var tableName = 'aq_particulate_matter';

  // Create an XMLHTTPRequest to get the Excel file from the server
  var xhr = new XMLHttpRequest();
  xhr.open('GET', window.location.origin + '/RAMHealth/scripts/export_script.php?table=' + tableName, true);
  xhr.responseType = 'arraybuffer';
  xhr.onload = function(e) {
    if (this.status == 200) {
      var arraybuffer = this.response;
      var data = new Uint8Array(arraybuffer);
      var workbook = XLSX.read(data, { type: 'array' });
      var worksheet = workbook.Sheets[workbook.SheetNames[0]];
      
      // Apply bold font style to the header row
      var headerRange = XLSX.utils.decode_range(worksheet['!ref']);
      for (var col = headerRange.s.c; col <= headerRange.e.c; col++) {
        var headerCell = XLSX.utils.encode_cell({ r: headerRange.s.r, c: col });
        var headerCellStyle = worksheet[headerCell].s || {};
        headerCellStyle.font = { bold: true };
        worksheet[headerCell].s = headerCellStyle;
      }
      
      var workbookOut = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbookOut, worksheet, 'Table Data');
      var excelBuffer = XLSX.write(workbookOut, { type: 'array' });
      var blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
      var url = URL.createObjectURL(blob);
      var link = document.createElement('a');
      link.href = url;
      link.download = tableName + '.xlsx';
      link.click();
    }
  };
  xhr.send();
}

function downloadGASExcelTable() {
  var tableName = 'aq_gas_level';

  // Create an XMLHTTPRequest to get the Excel file from the server
  var xhr = new XMLHttpRequest();
  xhr.open('GET', window.location.origin + '/RAMHealth/scripts/export_script.php?table=' + tableName, true);
  xhr.responseType = 'arraybuffer';
  xhr.onload = function(e) {
    if (this.status == 200) {
      var arraybuffer = this.response;
      var data = new Uint8Array(arraybuffer);
      var workbook = XLSX.read(data, { type: 'array' });
      var worksheet = workbook.Sheets[workbook.SheetNames[0]];
      
      // Apply bold font style to the header row
      var headerRange = XLSX.utils.decode_range(worksheet['!ref']);
      for (var col = headerRange.s.c; col <= headerRange.e.c; col++) {
        var headerCell = XLSX.utils.encode_cell({ r: headerRange.s.r, c: col });
        var headerCellStyle = worksheet[headerCell].s || {};
        headerCellStyle.font = { bold: true };
        worksheet[headerCell].s = headerCellStyle;
      }
      
      var workbookOut = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbookOut, worksheet, 'Table Data');
      var excelBuffer = XLSX.write(workbookOut, { type: 'array' });
      var blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
      var url = URL.createObjectURL(blob);
      var link = document.createElement('a');
      link.href = url;
      link.download = tableName + '.xlsx';
      link.click();
    }
  };
  xhr.send();
}

function downloadIndoorTempExcelTable() {
  var tableName = 'aq_indoor_temperature';

  // Create an XMLHTTPRequest to get the Excel file from the server
  var xhr = new XMLHttpRequest();
  xhr.open('GET', window.location.origin + '/RAMHealth/scripts/export_script.php?table=' + tableName, true);
  xhr.responseType = 'arraybuffer';
  xhr.onload = function(e) {
    if (this.status == 200) {
      var arraybuffer = this.response;
      var data = new Uint8Array(arraybuffer);
      var workbook = XLSX.read(data, { type: 'array' });
      var worksheet = workbook.Sheets[workbook.SheetNames[0]];
      
      // Apply bold font style to the header row
      var headerRange = XLSX.utils.decode_range(worksheet['!ref']);
      for (var col = headerRange.s.c; col <= headerRange.e.c; col++) {
        var headerCell = XLSX.utils.encode_cell({ r: headerRange.s.r, c: col });
        var headerCellStyle = worksheet[headerCell].s || {};
        headerCellStyle.font = { bold: true };
        worksheet[headerCell].s = headerCellStyle;
      }
      
      var workbookOut = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbookOut, worksheet, 'Table Data');
      var excelBuffer = XLSX.write(workbookOut, { type: 'array' });
      var blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
      var url = URL.createObjectURL(blob);
      var link = document.createElement('a');
      link.href = url;
      link.download = tableName + '.xlsx';
      link.click();
    }
  };
  xhr.send();
}

function downloadOutdoorTempExcelTable() {
  var tableName = 'aq_outdoor_temperature';

  // Create an XMLHTTPRequest to get the Excel file from the server
  var xhr = new XMLHttpRequest();
  xhr.open('GET', window.location.origin + '/RAMHealth/scripts/export_script.php?table=' + tableName, true);
  xhr.responseType = 'arraybuffer';
  xhr.onload = function(e) {
    if (this.status == 200) {
      var arraybuffer = this.response;
      var data = new Uint8Array(arraybuffer);
      var workbook = XLSX.read(data, { type: 'array' });
      var worksheet = workbook.Sheets[workbook.SheetNames[0]];
      
      // Apply bold font style to the header row
      var headerRange = XLSX.utils.decode_range(worksheet['!ref']);
      for (var col = headerRange.s.c; col <= headerRange.e.c; col++) {
        var headerCell = XLSX.utils.encode_cell({ r: headerRange.s.r, c: col });
        var headerCellStyle = worksheet[headerCell].s || {};
        headerCellStyle.font = { bold: true };
        worksheet[headerCell].s = headerCellStyle;
      }
      
      var workbookOut = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbookOut, worksheet, 'Table Data');
      var excelBuffer = XLSX.write(workbookOut, { type: 'array' });
      var blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
      var url = URL.createObjectURL(blob);
      var link = document.createElement('a');
      link.href = url;
      link.download = tableName + '.xlsx';
      link.click();
    }
  };
  xhr.send();
}

function downloadHumidityExcelTable() {
  var tableName = 'aq_relative_humidity';

  // Create an XMLHTTPRequest to get the Excel file from the server
  var xhr = new XMLHttpRequest();
  xhr.open('GET', window.location.origin + '/RAMHealth/scripts/export_script.php?table=' + tableName, true);
  xhr.responseType = 'arraybuffer';
  xhr.onload = function(e) {
    if (this.status == 200) {
      var arraybuffer = this.response;
      var data = new Uint8Array(arraybuffer);
      var workbook = XLSX.read(data, { type: 'array' });
      var worksheet = workbook.Sheets[workbook.SheetNames[0]];
      
      // Apply bold font style to the header row
      var headerRange = XLSX.utils.decode_range(worksheet['!ref']);
      for (var col = headerRange.s.c; col <= headerRange.e.c; col++) {
        var headerCell = XLSX.utils.encode_cell({ r: headerRange.s.r, c: col });
        var headerCellStyle = worksheet[headerCell].s || {};
        headerCellStyle.font = { bold: true };
        worksheet[headerCell].s = headerCellStyle;
      }
      
      var workbookOut = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbookOut, worksheet, 'Table Data');
      var excelBuffer = XLSX.write(workbookOut, { type: 'array' });
      var blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
      var url = URL.createObjectURL(blob);
      var link = document.createElement('a');
      link.href = url;
      link.download = tableName + '.xlsx';
      link.click();
    }
  };
  xhr.send();
}