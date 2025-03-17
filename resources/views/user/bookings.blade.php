<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis reservas') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg m-2 mt-5">
        @if ($bookings->isEmpty())
            <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg m-2">
                <p class="bg-red-500 text-white dark:text-slate-500 p-4 rounded-md">No tienes reservas</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
                @foreach ($bookings as $booking)
                    <div
                        class="bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg {{ $booking->slot->slot_date->isPast() ? 'opacity-50' : '' }}">
                        <div class="p-6 text-gray-900 dark:text-gray-200">
                            <h3 class="text-lg font-semibold mb-2">{{ $booking->slot->business->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $booking->slot->business->address }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ $booking->slot->business->phone }}
                            </p>
                            <p class="text-sm text-green-600 dark:text-green-300">{{ $booking->slot->start_time }} -
                                {{ $booking->slot->end_time }}</p>
                            <p class="text-sm font-semibold text-green-600 dark:text-green-300">
                                {{ $booking->slot->slot_date->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
