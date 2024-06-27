
<x-app-layout>

        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
        <script>

            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: '90%',
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: [
                            @foreach($events as $event)
                        {
                            title: '{{ $event->user_name }}',
                            start: '{{ $event->start }}',
                            end: '{{ $event->end }}',

                        },
                        @endforeach
                    ]
                });
                calendar.render();
            });

        </script>



    <div id="calendar-container" class="mt-9 flex flex-col items-center justify-center h-screen">
        <div id='calendar' class="w-full h-full max-w-6xl bg-white shadow-lg rounded-lg p-4"></div>
    </div>

</x-app-layout>

