<div class="sm:w-auto sm:min-w-0 sm:flex-1 bg-white border-gray-200 border-r">
<x-app-layout>
    <html lang='en'>
    <head>
        <meta charset='utf-8' />
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
        <script>

            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth'
                });
                calendar.render();
            });

        </script>
    </head>
    <body>
    <div id='calendar'></div>
    </body>
    </html>
</x-app-layout>
</div>
