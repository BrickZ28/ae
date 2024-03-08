
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin],
        timeZone: 'America/Chicago',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: {
            url: '/api/calendar/specials',
            method: 'GET',
            failure: function() {
                alert('There was an error while fetching events.');
            }
        },
        eventContent: function(arg) {
            // Event rendering logic...
        },
        dayCellDidMount: function(arg) {
            const today = new Date();
            const cellDate = arg.date;
            const cellEl = arg.el;

            // Compare the cell date with today's date
            if (cellDate.toDateString() === today.toDateString()) {
                // Change the background color of today's cell
                cellEl.style.backgroundColor = '#000000'; // Change to your desired color
            }
        }
    });

    calendar.render();
});
