<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Citas previas') }}
        </h2>
    </x-slot>

    <div class="overflow-hidden p-6 m-2 mt-5 bg-white shadow-sm dark:bg-gray-900 sm:rounded-lg">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($businesses as $business)
                <div class="overflow-hidden m-2 bg-gray-100 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6 mx-auto max-w-sm text-blue-400 dark:text-gray-300">
                        <img src="{{ $business->image }}" alt="{{ $business->name }}" class="mb-4 h-20 rounded-[10px]">
                        <h3 class="mb-2 text-lg font-semibold">{{ $business->name }}</h3>
                        <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">{{ $business->address }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $business->phone }}</p>

                        <ul class="mt-4 text-gray-500 space y-2 dark:text-gray-500">
                            @foreach ($business->schedules as $schedule)
                                <li>
                                    <span class="font-semibold text-gray-600 dark:text-gray-300">
                                        {{ $schedule->day_of_week_string }}:
                                    </span>
                                    @if (!$schedule->is_closed)
                                        {{ $schedule->open_time }} - {{ $schedule->close_time }}
                                    @else
                                        <span class="font-semibold text-red-600 dark:text-red-400">Cerrado</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <div class="pt-4 mt-4 border-t border-gray-300 dark:border-gray-600">
                            <a href="{{ route('slots.show', ['business' => $business, 'year' => now()->year, 'month' => now()->month, 'day' => now()->day]) }}"
                                class="px-5 py-3 font-bold text-green-600 bg-gray-200 rounded-full hover:bg-gray-400 focus:ring-4 focus:ring-gray-500 text-md dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-500">
                                Ver disponibilidad
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
