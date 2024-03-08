
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
            const eventTitle = arg.event.title;
            let eventBackgroundColor = '#808080'; // Default to grey for inactive or past events
            let eventBorderColor = '#808080'; // Default to blue for all events
            let eventTextColor = '#000000'; // Default to black for event text color

            const startDate = new Date(arg.event.start);
            const endDate = new Date(arg.event.end);
            const today = new Date();
            const isActive = arg.event.extendedProps['active'] === 1;
            const oneDay = 1000 * 60 * 60 * 24; // Milliseconds in a day

            // Check event status and set colors accordingly
            if (!isActive) {
                eventBackgroundColor = '#808080'; // Inactive events color
                eventBorderColor = '#808080'; // Inactive events color
            } else if (isActive) {
                eventBackgroundColor = '#3CB043'; // Active events color
                eventBorderColor = '#3CB043'; // Active events color
            } else if (endDate > today && startDate > today) {
                eventBackgroundColor = '#A32CC4'; // Future events color (purple)
                eventBorderColor = '#A32CC4'; // Future events color (purple)
            } else if (endDate - today <= oneDay && endDate > today) {
                eventBackgroundColor = '#D0312D'; // End date within 24 hours color (red)
                eventBorderColor = '#D0312D'; // End date within 24 hours color (red)
            } else if (startDate - today <= oneDay && startDate > today) {
                eventBackgroundColor = '#8D4004'; // Start date within 24 hours color (orange)
                eventBorderColor = '#8D4004'; // Start date within 24 hours color (orange)
            }

            // Construct event HTML with inline styles
            return {
                html: `<div class="event" style="background-color: ${eventBackgroundColor}; border-color: ${eventBorderColor}; color: ${eventTextColor};">${eventTitle}</div>`
            };
        }
    });

    calendar.render();
});
