<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8">
            Histórico de Registro de Pontos de {{ $user->name }}
            <span class="block mt-2 text-lg">Quantidade de Horas da Semana {{ $hoursPerWeek }}</span>
        </h1>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 overflow-x-auto">
                <!-- Dropdown Button -->
                <div class="relative">
                    <button id="dropdownRadioButton"
                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 rounded-lg text-sm px-4 py-2 font-medium focus:outline-none hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700 focus:ring-4 focus:ring-gray-100 transition"
                        type="button">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                        </svg>
                        Selecione a data
                        <svg class="w-3 h-3 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="dropdownRadio"
                        class="z-50 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-2">
                        <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownRadioButton">
                            @foreach (['1d' => 'Último dia', '7d' => 'Últimos 7 dias', '30d' => 'Últimos 30 dias', '1m' => 'Último mês', '1y' => 'Último ano'] as $value => $label)
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <input id="filter-radio-example-{{ $value }}" type="radio"
                                            value="{{ $value }}" name="filter-radio"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="filter-radio-example-{{ $value }}"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $label }}</label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Table -->
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-6 border-collapse">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3 text-center font-bold uppercase text-gray-500 dark:text-gray-200">
                                Data
                            </th>
                            <th class="px-6 py-3 text-center font-bold uppercase text-gray-500 dark:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Entrada
                            </th>
                            <th class="px-6 py-3 text-center font-bold uppercase text-gray-500 dark:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Saída
                            </th>
                            <th class="px-6 py-3 text-center font-bold uppercase text-gray-500 dark:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Total de Horas
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedRecords as $date => $records)
                            <tr>
                                <td colspan="4"
                                    class="text-left font-bold py-2 text-gray-500 dark:text-gray-200 border-t border-b dark:border-t-gray-600 dark:border-b-gray-600">
                                    {{ $date }}
                                </td>
                            </tr>
                            @foreach ($records as $punch)
                                <tr onclick="window.location.href='{{ route('user.show', ['user' => $user->id, 'punch' => $punch->id]) }}'"
                                    class="cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200 text-center">
                                        <!-- Possibly empty or some content here -->
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200 text-center">
                                        {{ \Carbon\Carbon::parse($punch->entry_time)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200 text-center">
                                        {{ $punch->departure_time ? \Carbon\Carbon::parse($punch->departure_time)->format('H:i') : '--:--' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200 text-center">
                                        {{ $punch->total_hours ?? '--:--' }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            // Toggle dropdown visibility on button click
            $('#dropdownRadioButton').on('click', function(e) {
                e.stopPropagation(); // Impede que o clique no botão feche o dropdown imediatamente
                $('#dropdownRadio').toggleClass('hidden');
            });

            // Change event for radio buttons to handle filtering
            $('input[name="filter-radio"]').on('change', function() {
                var filterValue = $(this).val();
                var url = new URL(window.location.href);
                url.searchParams.set('filter', filterValue);
                window.location.href = url.toString();
            });

            // Hide dropdown when clicking outside of it
            $(document).on('click', function(e) {
                var dropdown = $('#dropdownRadio');
                var button = $('#dropdownRadioButton');

                if (!dropdown.is(e.target) && dropdown.has(e.target).length === 0 && !button.is(e.target)) {
                    dropdown.addClass('hidden');
                }
            });
        });
    </script>

</x-app-layout>
