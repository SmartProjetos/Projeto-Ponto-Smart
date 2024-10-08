<x-app-layout>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8">
            Histórico de Registro de Pontos de {{ auth()->user()->name }}
            <span class="block mt-2 text-lg">Quantidade de Horas da Semana {{ $hoursPerWeek }}</span>
        </h1>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-3 overflow-x-auto">
                <div class="relative">
                    <!-- Dropdown Button -->
                    <button id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio"
                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        type="button">
                        <svg class="w-3 h-3 text-gray-500 dark:text-gray-400 me-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                        </svg>
                        Selecione a data
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdownRadio"
                        class="z-50 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-2">
                        <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownRadioButton">
                            @foreach ([['1d', 'Último dia'], ['7d', 'Últimos 7 dias'], ['30d', 'Últimos 30 dias'], ['1m', 'Último mês'], ['1y', 'Último ano']] as [$value, $label])
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <input id="filter-radio-example-{{ $loop->index + 1 }}" type="radio"
                                            value="{{ $value }}" name="filter-radio"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="filter-radio-example-{{ $loop->index + 1 }}"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                                            {{ $label }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Table -->
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-6">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase w-1/4 text-gray-500 dark:text-gray-200">
                                Data...</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500 dark:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Entrada
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500 dark:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Saida
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500 dark:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Total de Horas
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500 dark:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedRecords as $date => $records)
                            <tr>
                                <td colspan="5"
                                    class="text-left font-bold py-2 text-gray-500 dark:text-gray-200 border-t border-b dark:border-t-gray-600 dark:border-b-gray-600">
                                    {{ $date }}
                                </td>
                            </tr>
                            @foreach ($records as $punch)
                                <tr onclick="window.location.href='{{ route('record.show', $punch->id) }}'"
                                    class="cursor-pointer  hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-sm w-1/4 text-gray-500 dark:text-gray-200 text-center">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200 text-center">
                                        {{ \Carbon\Carbon::parse($punch->entry_time)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200 text-center">
                                        {{ $punch->departure_time ? \Carbon\Carbon::parse($punch->departure_time)->format('H:i') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200 text-center">
                                        {{ $punch->total_hours ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200 text-center">
                                        <a href="{{ route('record.destroy', $punch->id) }}"
                                            onclick="event.preventDefault(); deleteRecord(this);"
                                            class="inline-flex items-center px-4 py-2 bg-red-500 dark:bg-red-700 border border-transparent rounded-md
                                    font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900
                                    focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            Excluir
                                        </a>
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
        function deleteRecord(element) {
            event.stopPropagation();
            const url = element.getAttribute('href');

            Swal.fire({
                title: 'Tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

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
                window.location.href = url.toString(); // Redireciona com o novo parâmetro de filtro
            });

            // Hide dropdown when clicking outside of it
            $(document).on('click', function(e) {
                var dropdown = $('#dropdownRadio');
                var button = $('#dropdownRadioButton');

                // Verifica se o clique foi fora do dropdown e do botão
                if (!button.is(e.target) && button.has(e.target).length === 0 && !dropdown.is(e.target) &&
                    dropdown.has(e.target).length === 0) {
                    dropdown.addClass('hidden');
                }
            });
        });
    </script>
</x-app-layout>
