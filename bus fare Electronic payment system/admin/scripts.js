// scripts.js
function downloadTXT(reportTitle) {
    // Get the report data
    var reportData = document.getElementById('report_' + reportTitle).innerText;
    
    // Create a Blob with the report data
    var blob = new Blob([reportData], { type: 'text/plain' });
    
    // Create a link element
    var downloadLink = document.createElement('a');
    downloadLink.download = reportTitle + '.txt';
    
    // Create a URL for the Blob and set it as the href of the link
    downloadLink.href = window.URL.createObjectURL(blob);
    
    // Append the link to the body
    document.body.appendChild(downloadLink);
    
    // Simulate a click on the link to trigger the download
    downloadLink.click();
    
    // Remove the link from the body
    document.body.removeChild(downloadLink);
  }
  