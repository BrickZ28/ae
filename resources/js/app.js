
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

            const startDate = new Date(arg.event.start);
            const endDate = new Date(arg.event.end);
            const today = new Date();
            const isActive = arg.event.extendedProps['active'] === 1;
            const oneDay = 1000 * 60 * 60 * 24;// Check if active is 1 (true)

            // Check if the event is active
            if (!isActive) {
                eventBackgroundColor = '#808080'; // Active events color
                eventBorderColor = '#808080'; // Active events color
            }

            // Check if the event is active
            else if (isActive) {
                eventBackgroundColor = '#3CB043'; // Active events color
                eventBorderColor = '#3CB043'; // Active events color
            }

            // Check if the event is in the future
            else if (endDate > today && startDate > today) {
                eventBackgroundColor = '#A32CC4'; // Future events color (purple)
                eventBorderColor = '#A32CC4'; // Future events color (purple)
            }

            // Check if the end date is within 24 hours
            // Milliseconds in a day
            else if (endDate - today <= oneDay && endDate > today) {
                eventBackgroundColor = '#D0312D'; // End date within 24 hours color (red)
                eventBorderColor = '#D0312D'; // End date within 24 hours color (red)
            }

            // // Check if the start date is within 24 hours
            // else if (startDate - today <= oneDay && startDate > today) {
            //     eventBackgroundColor = '#8D4004'; // Start date within 24 hours color (orange)
            //     eventBorderColor = '#8D4004'; // Start date within 24 hours color (orange)
            // }

            return { html: `<div class="event" style="background-color: ${eventBackgroundColor}; border-color: ${eventBorderColor};">${eventTitle}</div>` };
        }
    });
    calendar.render();
});
