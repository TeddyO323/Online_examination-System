<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-GLhlTQ8i6IqX/l9JT979Fcb9TCQpYXz1TC3h9vbl5L/2Un5QJfC+st2Iq4miDl4" crossorigin="anonymous">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }
        .calendar {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #e48d2a;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
        }
        .day {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .day:hover {
            background-color: #f0f0f0;
        }
        .events {
            padding: 15px;
        }
        .event {
            margin-bottom: 10px;
        }
        .event span {
            color: #e48d2a;
        }
        .today {
            background-color: #e48d2a;
            color: #fff;
        }

/* Add this CSS for the modal */
.modal {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 82%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.7);
    margin-left: 20%;

}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #e48d2a;
    width: 50%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
/* Add this CSS for the previous and next month buttons */
.button-container {
    align-items: center;
}

.button-container button {
    background-color: #fff; /* Change the background color as needed */
    color: #e48d2a; /* Set text color to contrast with background */
    border: none;
    padding: 10px 15px;
    margin: 0 5px;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
}

.button-container button:hover {
    background-color: #0056b3; /* Change the background color on hover */
}


    </style>
    <title>Custom Calendar</title>
</head>
<body>
    
<div class="app-main__outer">
    <div class="app-main__inner">

<div class="calendar">
    <div class="header">
    <div class="button-container">
    <button onclick="previousMonth()">🢀</button>
    <span id="month-year"></span>
    <button onclick="nextMonth()">🢂</button>
</div>



    </div>
    <div class="days" id="days"></div>
    <div class="events" id="events"></div>
</div>
<div class="app-main__outer">
    <div class="app-main__inner">
<!-- Add this modal HTML structure to your document -->
<div id="examModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeExamModal()">&times;</span>
        <div id="examDetails"></div>
    </div>
</div>

</div>
</div>

<script>
    let currentDate = new Date();

  // ... Your existing code

function renderCalendar() {
    const daysElement = document.getElementById('days');
    const monthYearElement = document.getElementById('month-year');

    // Clear previous content
    daysElement.innerHTML = '';
    monthYearElement.textContent = '';

    // Set month and year
    const monthOptions = { month: 'long', year: 'numeric' };
    monthYearElement.textContent = currentDate.toLocaleDateString('en-US', monthOptions);

    // Get the first day of the month
    const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    const startingDay = firstDayOfMonth.getDay();

    // Get the last day of the month
    const lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
    const totalDays = lastDayOfMonth.getDate();

    // Populate days
    for (let i = 0; i < startingDay; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.classList.add('day');
        daysElement.appendChild(emptyDay);
    }

    for (let i = 1; i <= totalDays; i++) {
        const dayElement = document.createElement('div');
        dayElement.classList.add('day');
        dayElement.textContent = i;
        dayElement.addEventListener('click', () => showEvents(i));

        // Highlight today's date
        if (
            i === new Date().getDate() &&
            currentDate.getMonth() === new Date().getMonth() &&
            currentDate.getFullYear() === new Date().getFullYear()
        ) {
            dayElement.classList.add('today');
        }

        // Display event indicator for relevant dates
        const eventIndicator = document.createElement('div');
        eventIndicator.classList.add('event-indicator');

        // Fetch and display events
        fetchAndDisplayEvents(i, eventIndicator);

        dayElement.appendChild(eventIndicator);
        daysElement.appendChild(dayElement);
    }
}


function fetchAndDisplayEvents(day, eventIndicator) {
    // Simulate fetching events from a database based on the day, month, and year
    // In a real-world scenario, you would use AJAX to fetch data from the server

    // Get the current month and year
    const currentMonth = currentDate.getMonth() + 1; // Months are zero-indexed, so add 1
    const currentYear = currentDate.getFullYear();

    const url = `pages/your_server_script.php?day=${day}&month=${currentMonth}&year=${currentYear}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                eventIndicator.style.display = 'block';
                // Set innerHTML to a dot or any HTML element that represents a dot
                eventIndicator.innerHTML = '&#9632;';
            }
        })
        .catch(error => console.error('Error fetching events:', error));
}



function showEvents(day) {
    // Fetch events for the clicked day and display them
    // Make an AJAX request to your server script to fetch event details
    // You can use Fetch API for this

    // Fetch exam information for the clicked date using AJAX
    fetchExamInformation(day);
}
function fetchExamInformation(day) {
    // Get the current month and year
    const currentMonth = currentDate.getMonth() + 1; // Months are zero-indexed, so add 1
    const currentYear = currentDate.getFullYear();
    const regNo = '12345';  // Replace with the actual registration number from your session

    // Make an AJAX request to your server-side script
    var xhr = new XMLHttpRequest();
    xhr.open('GET', `pages/your_server_script.php?day=${day}&month=${currentMonth}&year=${currentYear}&reg_no=${regNo}`, true);

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Parse the JSON response
            var events = JSON.parse(xhr.responseText);

            // Display the exam information in a modal
            var eventDetails = '';

            if (events.length > 0) {
                eventDetails += 'Events for ' + formatDate(currentYear, currentMonth, day) + ':<br>';

                events.forEach(function (event) {
                    // Extract only the time portion
                    var startTime = event.exam_start_datetime.substring(11, 19);

                    eventDetails += '<br>Title: ' + event.exam_title +
                        '<br>Start Time: ' + startTime +
                        '<br>Time Limit: ' + event.exam_time_limit + ' Minutes' +
                        '<br>Description: ' + event.exam_description +
                        '<br>Attempts Allowed: ' + event.attempts_allowed +
                        '<br>Link to Exam: <a href="index.php?pages=instructions&exam_id=' + event.ex_id + '">Go to Exam</a>' +
                        '<br>';
                        '<br>';
                });

                // Update the modal content
                document.getElementById('examDetails').innerHTML = eventDetails;
            } else {
                eventDetails = 'No events for ' + formatDate(currentYear, currentMonth, day) + '<br>Enjoy The Silence!!' + '<br>';
            }

            // Display the modal
            document.getElementById('examDetails').innerHTML = eventDetails;
            document.getElementById('examModal').style.display = 'block';
        } else {
            console.error('Error fetching exam information');
        }
    };

    xhr.send();
}

// Close the modal
function closeExamModal() {
    document.getElementById('examModal').style.display = 'none';
}

// Helper function to format the date as dd:mm:yyyy
function formatDate(year, month, day) {
    return `${day.toString().padStart(2, '0')}:${month.toString().padStart(2, '0')}:${year}`;
}




    function previousMonth() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    }

    function nextMonth() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    }

    // Initial rendering
    renderCalendar();
</script>

<!-- Add this script to your HTML page -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add a click event listener to each date cell
        var dateCells = document.querySelectorAll('.date-cell');
        dateCells.forEach(function (dateCell) {
            dateCell.addEventListener('click', function () {
                // Get the date value associated with the clicked cell
                var clickedDate = dateCell.dataset.date;

                // Fetch exam information for the clicked date using AJAX
                fetchExamInformation(clickedDate);
            });
        });

        function fetchExamInformation(date) {
            // Make an AJAX request to your server-side script
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'pages/your_server_script.php?date=' + date, true);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Parse the JSON response
                    var examData = JSON.parse(xhr.responseText);

                    // Display the exam information (replace this with your logic)
                    alert('Exam Title: ' + examData.exam_title + '<br>Start Time: ' + examData.exam_start_datetime);
                } else {
                    console.error('Error fetching exam information');
                }
            };

            xhr.send();
        }
    });
</script>

</body>
</html>
