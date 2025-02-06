<x-app-layout>
    <x-slot name="header">

        <h1 class="text-xl font-semibold leading-tight text-cyan-800 dark:text-cyan-200">
            {{ __('Citas disponibles en :business para el día: :date', [
                'business' => $business->name,
                'date' => $date->isoFormat('dddd, D [de] MMMM [de] YYYY'),
            ]) }}
        </h1>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg m-2 mt-5">
        <div class="flex items-center justify-around">
            @dateNotIsToday($date)
            @php $copy = $date->copy()->subDay(); @endphp
            <a
                href="{{ route('slots.show', ['business' => $business, 'year' => $copy->year, 'month' => $copy->month, 'day' => $copy->day]) }}"
                class="bg-cyan-600 dark:bg-cyan-400 text-white inline-flex items-center dark:text-gray-900 font-semibold py-2 px-4 rounded-full hover:bg-cyan-500 dark:hover:bg-cyan-300"
            ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M14 8a.75.75 0 0 1-.75.75H4.56l1.22 1.22a.75.75 0 1 1-1.06 1.06l-2.5-2.5a.75.75 0 0 1 0-1.06l2.5-2.5a.75.75 0 0 1 1.06 1.06L4.56 7.25h8.69A.75.75 0 0 1 14 8Z" clip-rule="evenodd" />
                </svg>

                Día anterior
            </a>
            @enddateNotIsToday

            <div class="text-center">
                <h2 class="text-lg text-white font-semibold mb-2">{{ $business->name }}</h2>
            </div>

            @dateWithinMaxFutureDays($date, $business)
            @php $copy = $date->copy()->addDay(); @endphp
            <a
                href="{{ route('slots.show', ['business' => $business, 'year' => $copy->year, 'month' => $copy->month, 'day' => $copy->day]) }}"
                class="bg-cyan-600 dark:bg-cyan-400 text-white inline-flex items-center dark:text-gray-900 font-semibold py-2 px-4 rounded-full hover:bg-cyan-500 dark:hover:bg-cyan-300"
            >
                Día siguiente

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M2 8c0 .414.336.75.75.75h8.69l-1.22 1.22a.75.75 0 1 0 1.06 1.06l2.5-2.5a.75.75 0 0 0 0-1.06l-2.5-2.5a.75.75 0 1 0-1.06 1.06l1.22 1.22H2.75A.75.75 0 0 0 2 8Z" clip-rule="evenodd" />
                </svg>


            </a>
            @enddateWithinMaxFutureDays
        </div>
    </div>

    @if($business->slots->isEmpty())
        <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg m-2">
            <p class="bg-red-500 text-white p-4 rounded-md">No hay horarios disponibles para este día</p>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 p-2 text-center">
        @foreach ($business->slots as $slot)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $slot->start_time }} - {{ $slot->end_time }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 {{ $slot->isBooked() ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                        @if($slot->isBooked())
                            @if($slot->isMyBooking())
                                Reservado por mi
                            @else
                                Reservado
                            @endif
                        @else
                            Disponible
                        @endif
                    </p>
                </div>

                @if($slot->canBeBooked())
                    <div class="mb-6 bg-white dark:bg-gray-800">
                        @if(auth()->user()->hasCredits())
                            <form action="{{ route('slots.book', ['business' => $business, 'slot' => $slot]) }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="bg-green-600 dark:bg-green-400 text-white dark:text-gray-900 font-semibold py-2 px-4 rounded-full hover:bg-green-500 dark:hover:bg-green-300"
                                >
                                    Reservar
                                </button>
                            </form>
                        @else
                            <button
                                class="bg-gray-600 dark:bg-gray-400 text-white dark:text-gray-900 font-semibold py-2 px-4 rounded cursor-not-allowed"
                                disabled
                            >
                                Sin créditos
                            </button>
                        @endif
                    </div>
                @else
                    <div class="mb-6 bg-white dark:bg-gray-800">
                        <button
                            class="bg-gray-600 dark:bg-gray-400 text-white dark:text-gray-900 font-semibold py-2 px-4 rounded cursor-not-allowed"
                            disabled
                        >
                            No se puede reservar
                        </button>
                    </div>
                @endif

                @if($slot->isMyBooking())
                    <div class="mb-6 bg-white dark:bg-gray-800">
                        @if($slot->canCancelBook())
                            <form action="{{ route('bookings.cancel', ['business' => $business, 'booking' => $slot->booking]) }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="bg-red-600 dark:bg-red-400 text-white dark:text-gray-900 font-semibold py-2 px-4 rounded hover:bg-red-500 dark:hover:bg-red-300"
                                >
                                    Cancelar
                                </button>
                            </form>
                        @else
                            <button
                                class="bg-gray-600 dark:bg-gray-400 text-white dark:text-gray-900 font-semibold py-2 px-4 rounded cursor-not-allowed"
                                disabled
                            >
                                No se puede cancelar
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>
