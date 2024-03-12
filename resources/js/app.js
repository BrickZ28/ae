// calendar.js
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
            const eventDescription = arg.event.extendedProps.description || ''; // Set default description to empty string if not provided
            let eventBackgroundColor = '#808080'; // Default to grey for inactive or past events
            let eventBorderColor = '#808080'; // Default to blue for all events
            let eventTextColor = '#000000'; // Default to black for event text color

            const startDate = new Date(arg.event.start);
            const endDate = new Date(arg.event.end);
            const today = new Date();
            const isActive = arg.event.extendedProps['active'] === 1;
            const oneDay = 1000 * 60 * 60 * 24; // Milliseconds in a day

            // Check event status and set colors accordingly
            if (isActive) {
                eventBackgroundColor = '#3CB043'; // Active events color
                eventBorderColor = '#3CB043'; // Active events color
            } else if (endDate > today && startDate >= today) {
                eventBackgroundColor = '#A32CC4'; // Future events color (purple)
                eventBorderColor = '#A32CC4'; // Future events color (purple)
            } else if (endDate - today <= oneDay && endDate > today) {
                eventBackgroundColor = '#D0312D'; // End date within 24 hours color (red)
                eventBorderColor = '#D0312D'; // End date within 24 hours color (red)
            } else if (startDate - today <= oneDay && startDate > today) {
                eventBackgroundColor = '#8D4004'; // Start date within 24 hours color (orange)
                eventBorderColor = '#8D4004'; // Start date within 24 hours color (orange)
            }

            // Construct event HTML with inline styles and link to description
            return {
                html: `<div class="event" style="background-color: ${eventBackgroundColor}; border-color: ${eventBorderColor}; color: ${eventTextColor};"><a href="#" class="event-link" data-title="${eventTitle}" data-description="${eventDescription}" style="color: black;">${eventTitle}</a></div>`
            };
        }
    });

    calendar.render();

    // Handle event click to open modal
    document.addEventListener('click', function(event) {
        const target = event.target;
        if (target.classList.contains('event-link')) {
            event.preventDefault();
            const title = target.dataset.title;
            const description = target.dataset.description;
            openModal(title, description);
        }
    });
    // Function to open modal
    function openModal(title, description) {
        // Create modal element
        const modal = document.createElement('div');
        modal.classList.add('modal');
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>${description}</p>
                    </div>
                </div>
            </div>
        `;

        // Append modal to body
        document.body.appendChild(modal);

        // Show modal
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();

        // Remove modal from DOM when closed
        modal.addEventListener('hidden.bs.modal', function() {
            document.body.removeChild(modal);
        });
    }
});

