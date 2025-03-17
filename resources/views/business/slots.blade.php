<x-app-layout>
    <x-slot name="header">

        <h1 class="text-xl font-semibold leading-tight text-center text-gray-800 dark:text-gray-200">
            {{ __('Citas disponibles en :business para el día: :date', [
                'business' => $business->name,
                'date' => $date->isoFormat('dddd, D [de] MMMM [de] YYYY'),
            ]) }}
        </h1>
    </x-slot>

    <div class="overflow-hidden p-6 m-2 mt-5 bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
        <div class="flex justify-center items-center text-center">
            @dateNotIsToday($date)
                @php $copy = $date->copy()->subDay(); @endphp
                <a href="{{ route('slots.show', ['business' => $business, 'year' => $copy->year, 'month' => $copy->month, 'day' => $copy->day]) }}"
                    class="inline-flex items-center px-2 py-1 font-semibold text-white bg-red-600 rounded-full dark:bg-red-400 dark:text-gray-900 hover:bg-cyan-500 dark:hover:bg-cyan-300"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M14 8a.75.75 0 0 1-.75.75H4.56l1.22 1.22a.75.75 0 1 1-1.06 1.06l-2.5-2.5a.75.75 0 0 1 0-1.06l2.5-2.5a.75.75 0 0 1 1.06 1.06L4.56 7.25h8.69A.75.75 0 0 1 14 8Z"
                            clip-rule="evenodd" />
                    </svg>

                    Día anterior
                </a>
            @enddateNotIsToday

            <div class="text-center">
                <h2 class="px-5 mr-5 text-lg font-semibold text-gray-700 dark:text-gray-500">{{ $business->name }}:</h2>
            </div>

            @dateWithinMaxFutureDays($date, $business)
                @php $copy = $date->copy()->addDay(); @endphp
                <a href="{{ route('slots.show', ['business' => $business, 'year' => $copy->year, 'month' => $copy->month, 'day' => $copy->day]) }}"
                    class="inline-flex items-center px-2 py-1 font-semibold text-white bg-green-600 rounded-full dark:bg-green-400 dark:text-gray-900 hover:bg-green-500 dark:hover:bg-green-300"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M2 8c0 .414.336.75.75.75h8.69l-1.22 1.22a.75.75 0 1 0 1.06 1.06l2.5-2.5a.75.75 0 0 0 0-1.06l-2.5-2.5a.75.75 0 1 0-1.06 1.06l1.22 1.22H2.75A.75.75 0 0 0 2 8Z"
                            clip-rule="evenodd" />
                    </svg>
                    Día siguiente
                </a>
            @enddateWithinMaxFutureDays
        </div>
    </div>

    @if ($business->slots->isEmpty())
        <div class="overflow-hidden m-2 text-center shadow-sm">
            <p class="p-8 text-red-500 bg-white dark:text-red-300 dark:bg-gray-800">No hay horarios disponibles para
                este día</p>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 p-2 text-center sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
        @foreach ($business->slots as $slot)
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $slot->start_time }} - {{ $slot->end_time }}
                    </p>
                    <p
                        class="text-sm text-gray-600 dark:text-gray-400 {{ $slot->isBooked() ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                        @if ($slot->isBooked())
                            @if ($slot->isMyBooking())
                                Reservado por mi
                            @else
                                Reservado
                            @endif
                        @else
                            Disponible
                        @endif
                    </p>
                </div>

                @if ($slot->canBeBooked())
                    <div class="mb-6 bg-white dark:bg-gray-800">
                        @if (auth()->user()->hasCredits())
                            <form action="{{ route('slots.book', ['business' => $business, 'slot' => $slot]) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 font-semibold text-green-600 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500">
                                    Reservar
                                </button>
                            </form>
                        @else
                            <button
                                class="px-4 py-2 font-semibold text-white bg-gray-600 rounded cursor-not-allowed dark:bg-gray-400 dark:text-gray-900"
                                disabled>
                                Sin créditos
                            </button>
                        @endif
                    </div>
                @else
                    <div class="mb-6 bg-white dark:bg-gray-800">
                        <button
                            class="px-4 py-2 font-semibold text-white bg-gray-600 rounded cursor-not-allowed dark:bg-gray-400 dark:text-gray-900"
                            disabled>
                            No se puede reservar
                        </button>
                    </div>
                @endif

                @if ($slot->isMyBooking())
                    <div class="mb-6 bg-white dark:bg-gray-800">
                        @if ($slot->canCancelBook())
                            <form
                                action="{{ route('bookings.cancel', ['business' => $business, 'booking' => $slot->booking]) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 font-semibold text-white bg-red-600 rounded dark:bg-red-400 dark:text-gray-900 hover:bg-red-500 dark:hover:bg-red-300">
                                    Cancelar
                                </button>
                            </form>
                        @else
                            <button
                                class="px-4 py-2 font-semibold text-white bg-gray-600 rounded cursor-not-allowed dark:bg-gray-400 dark:text-gray-900"
                                disabled>
                                No se puede cancelar
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>
