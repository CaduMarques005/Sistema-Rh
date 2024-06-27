<x-app-layout>

    @if(!$events)
        <div class="mt-24">

            <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
                {{ __('There aren´t any request at the moment! :)') }}
            </h2>

        </div>
        @else

        <div class="flex mt-24">

            @foreach($events as $event)
                @foreach($users as $user)
                    <div class="p-5">
                        <figure class="flex flex-col items-center justify-center p-6 text-center bg-white border-b border-gray-200 rounded-t-lg md:rounded-t-none md:rounded-ss-lg md:border-e dark:bg-gray-800 dark:border-gray-700">
                            <blockquote class="max-w-2xl mx-auto mb-4 text-gray-500 lg:mb-8 dark:text-gray-400">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{$event->start}} <hr>to <hr>{{$event->end}}</h3>

                            </blockquote>
                            <figcaption class="flex items-center justify-center ">
                                <img class="rounded-full w-9 h-9" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/karen-nelson.png" alt="profile picture">
                                <div class="space-y-0.5 font-medium dark:text-white text-left rtl:text-right ms-3">

                                    <div>{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 ">{{ $user->email }}</div>
                                    <div class="text-sm">{{ $user->position }}</div>
                                </div>
                            </figcaption>
                            <div class="flex mt-6">
                                <form class="mr-5" action="{{ route('approve', $event->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                        Accept
                                    </button>
                                </form>

                                <form class="mr-5" action="{{ route('denied', $event->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                        Denied
                                    </button>
                                </form>


                            </div>
                        </figure>

                    </div>
                @endforeach
            @endforeach

        </div>

    @endif




</x-app-layout>
