// Function to show an alert
var isExamTime = true; // You might set this based on your exam logic

document.addEventListener('copy', function (e) {
    if (isExamTime) {
        showAlert('Copying is not allowed during the exam.');
        e.preventDefault();
    }
});

document.addEventListener('cut', function (e) {
    if (isExamTime) {
        showAlert('Cutting is not allowed during the exam.');
        e.preventDefault();
    }
});

document.addEventListener('paste', function (e) {
    if (isExamTime) {
        showAlert('Pasting is not allowed during the exam.');
        e.preventDefault();
    }
});

document.addEventListener('contextmenu', function (e) {
    if (isExamTime) {
        showAlert('Right-click is not allowed during the exam.');
        e.preventDefault();
    }
});

// Other exam-related code

$(document).ready(function () {

    // Get the initial time limit in seconds from the hidden input
    var initialTimeLimitInSeconds = parseInt($('#initialTimeLimit').val());

    // Get the stored time limit in seconds from sessionStorage
    var storedTimeLimitInSeconds = sessionStorage.getItem('examTimeLimit_' + examId + '_' + regNo);

    // Use the stored value if available; otherwise, use the initial value
    var timeLimitInSeconds = storedTimeLimitInSeconds !== null ? parseInt(storedTimeLimitInSeconds) : initialTimeLimitInSeconds;

    // Set the initial value of the timer
    setTimerValue(timeLimitInSeconds);

    // Store the initial time limit in sessionStorage if not already stored
    if (storedTimeLimitInSeconds === null) {
        sessionStorage.setItem('examTimeLimit_' + examId + '_' + regNo, initialTimeLimitInSeconds);
    }

    var timerInterval = setInterval(function () {
        if (timeLimitInSeconds > 0) {
            timeLimitInSeconds--;
            setTimerValue(timeLimitInSeconds);
        } else {
            clearInterval(timerInterval);
            alert('Time is up!');

            // Reset the timer back to the original value
            timeLimitInSeconds = initialTimeLimitInSeconds;
            setTimerValue(timeLimitInSeconds);

            // Automatically submit the form
            document.getElementById('examForm').submit();
        }
    }, 1000);
    // Function to set the value of the timer input
    function setTimerValue(seconds) {
        var hours = Math.floor(seconds / 3600);
        var minutes = Math.floor((seconds % 3600) / 60);
        var remainingSeconds = seconds % 60;

        var formattedTime = padZero(hours) + ':' + padZero(minutes) + ':' + padZero(remainingSeconds);

        // Update the timer input
        $('#txt').val(formattedTime);

        // Store the current timer value in sessionStorage
        sessionStorage.setItem('examTimeLimit_' + examId + '_' + regNo, seconds);
    }

    // Function to pad zero for single-digit numbers
    function padZero(num) {
        return num < 10 ? '0' + num : num;
    }
});

tinymce.init({
    selector: 'textarea',
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    toolbar_mode: 'floating',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name'
});
