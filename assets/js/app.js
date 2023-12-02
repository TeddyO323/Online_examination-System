  // ... Your existing updateProgressBar function code ...
  function updateProgressBar() {
    const now = new Date();
    const nowGMT3 = new Date(now.getTime() + (3 * 60 * 60 * 1)); // Adjust for GMT+3

    const startOfYear = new Date(nowGMT3.getFullYear(), 0, 1);
    const isLeapYear = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
    
    const endOfYear = new Date(nowGMT3.getFullYear() + 1, 0, 1);
    const totalDays = Math.ceil((endOfYear - startOfYear) / (1000 * 60 * 60 * 24));
    const elapsedDays = Math.ceil((nowGMT3 - startOfYear) / (1000 * 60 * 60 * 24));
    const percentage = (elapsedDays / totalDays) * 100;
    // ... Your existing updateProgressBar function code ...

// Calculate year percentage without decimal points
const percentageWithoutDecimals = Math.floor(percentage);

document.getElementById('days_percentage').textContent = percentageWithoutDecimals + '%';
document.getElementById('year').textContent = nowGMT3.getFullYear();
document.getElementById('days_total').textContent = elapsedDays;
document.getElementById('maxdays').textContent = totalDays;

    const progressBar = document.getElementById('progress');
    progressBar.style.width = percentage + '%';

    // Update server time information
    document.getElementById('servertime').textContent = nowGMT3.toLocaleString();
    document.getElementById('servertime12H').textContent = nowGMT3.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
    document.getElementById('servertime24H').textContent = nowGMT3.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: false });

    // Schedule the next update after a certain interval
    setTimeout(updateProgressBar, 60000); // Update every 60 seconds
  }

  // Initial call to start the update process
  updateProgressBar();

  // Update server time information
  const serverDateElement = document.getElementById('server_date');
  const nowGMT3 = new Date(now.getTime() + (3 * 60 * 60 * 1000)); // Adjust for GMT+3
  serverDateElement.textContent = nowGMT3.toDateString();

 // Schedule the next update after a certain interval
  setTimeout(updateProgressBar, 60000); // Update every 60 seconds
// Initial call to start the update process
updateProgressBar();
/* particlesJS.load(@dom-id, @path-json, @callback (optional)); */


