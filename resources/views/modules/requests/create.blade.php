<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<x-app-layout>

    <style>
        .flatpickr-calendar {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .flatpickr-time {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <div class="mt-24 p-4" >
        <form action="{{route('requests.store')}}" class="text-center" method="post">
            @csrf
            <div class="">
                <h1>
                    Request your vacation {{ Auth::user()->hours }}
                </h1>
            </div>

            <div class="max-w-md mx-auto">
                <label for="start_datetimepicker" class="block text-sm font-medium text-gray-700">Select start date:</label>
                <input type="text" id="start_datetimepicker" name="start" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="max-w-md mx-auto">
                <label for="end_datetimepicker" class="block text-sm font-medium text-gray-700">Select end date:</label>
                <input type="text" id="end_datetimepicker" name="end" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mt-5">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create</button>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const startDatetimePicker = flatpickr("#start_datetimepicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            onChange: function(selectedDates, dateStr, instance) {
                endDatetimePicker.set('minDate', dateStr);
            }
        });

        const endDatetimePicker = flatpickr("#end_datetimepicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            onChange: function(selectedDates, dateStr, instance) {
                startDatetimePicker.set('maxDate', dateStr);
            }
        });
    </script>
</x-app-layout>
