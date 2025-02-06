<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cyan-800 dark:text-cyan-200 leading-tight">
            {{ __('Citas previas') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg m-2 mt-5">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($businesses as $business)
                <div class="bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-cyan-900 dark:text-cyan-200 max-w-sm">
                        <img src="{{ $business->image }}" alt="{{ $business->name }}" class="w-full h-32 rounded mb-4 object-fill">
                        <h3 class="text-lg font-semibold mb-2">{{ $business->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-100 mb-2">{{ $business->address }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-100">{{ $business->phone }}</p>

                        <ul class="mt-4 space y-2">
                            @foreach ($business->schedules as $schedule)
                                <li>
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $schedule->day_of_week_string }}:
                                    </span>
                                    @if(! $schedule->is_closed)
                                        {{ $schedule->open_time }} - {{ $schedule->close_time }}
                                    @else
                                        <span class="font-semibold text-red-800 dark:text-red-400">Cerrado</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-4 border-t border-gray-300 dark:border-gray-600 pt-4">
                            <a href="{{ route('slots.show', ['business' => $business, 'year' => now()->year, 'month' => now()->month, 'day' => now()->day]) }}"
                               class="text-cyan-800 dark:text-cyan-500 hover:underline"
                            >
                                Ver disponibilidad
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
