<x-app-layout>

    <style>
        #weeklyHoursChart {
            max-height: 250px;
            /* Define a altura máxima */
            width: 100%;
            /* Garante que a largura se ajuste */
        }
    </style>

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
        <div class="container mx-auto py-6">
            <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-4">
                Horas Trabalhadas - Semana Atual
            </h2>

            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-4">
                <div class="relative">
                    <canvas id="weeklyHoursChart" class="max-h-64"></canvas>
                </div>
            </div>
        </div>



        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8">
            Histórico de Registro de Pontos de {{ auth()->user()->name }}
            <span class="block mt-2 text-lg">Quantidade de Horas da Semana {{ $hoursPerWeek }}</span>
        </h1>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-3 overflow-x-auto">

                <form action="{{ route('record.store2') }}" method="POST"
                    class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md space-y-4" id="filter-form">
                    @csrf

                    <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8">Selecionar
                        Intervalo de Datas</h2>

                    <div id="reportrange"
                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                    {{-- <input type="text" name="daterange" id="daterange"
                        class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="Selecione o intervalo de datas" /> --}}

                    <input type="hidden" name="start-date" id="start-date">
                    <input type="hidden" name="end-date" id="end-date">


                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Filtrar
                    </button>
                </form>






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
        jQuery.noConflict();
        jQuery(function($) {
            // Inicializa o DateRangePicker para o reportrange
            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#start-date').val(start.format('YYYY-MM-DD'));
                $('#end-date').val(end.format('YYYY-MM-DD'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                locale: {
                    format: 'MMMM D, YYYY',
                    applyLabel: 'Aplicar',
                    cancelLabel: 'Cancelar',
                    fromLabel: 'De',
                    toLabel: 'Até',
                    daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                    monthNames: [
                        'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                    ],
                    firstDay: 0
                },
                ranges: {
                    'Hoje': [moment(), moment()],
                    'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                    'Este Mês': [moment().startOf('month'), moment().endOf('month')],
                    'Último Mês': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },

            }, cb);

            cb(start, end);
        });
    </script>


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

    <script>
        var days = @json($days); // Dias da semana
        var minutesByDay = @json($minutesByDay); // Minutos totais
        console.log(minutesByDay);

        // Função para converter minutos para o formato hh:mm
        function formatMinutesToHHMM(minutes) {
            let hours = Math.floor(minutes / 60);
            let remainingMinutes = minutes % 60;
            return hours.toString().padStart(2, '0') + ':' + remainingMinutes.toString().padStart(2, '0');
        }

        // Convertendo os minutos para hh:mm
        var hoursFormatted = minutesByDay.map(formatMinutesToHHMM);

        var ctx = document.getElementById('weeklyHoursChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: days,
                datasets: [{
                    label: 'Tempo Trabalhado (hh:mm)',
                    data: minutesByDay, // Mantém os minutos para facilitar escalas no gráfico
                    backgroundColor: 'rgba(76, 154, 255, 0.2)',
                    borderColor: '#4C9AFF',
                    borderWidth: 2,
                    pointBackgroundColor: '#3182CE',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    tension: 0.4 // Suavizar linha
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Permitir que o gráfico se ajuste
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: {
                                size: 12 // Tamanho da fonte da legenda
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let rawMinutes = context.raw; // Valor original em minutos
                                return formatMinutesToHHMM(rawMinutes) + ' (hh:mm)';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Tempo Trabalhado (Minutos)',
                            font: {
                                size: 14 // Tamanho da fonte do título
                            }
                        },
                        ticks: {
                            font: {
                                size: 12 // Tamanho da fonte dos ticks
                            },
                            callback: function(value) {
                                return formatMinutesToHHMM(value); // Mostrar como hh:mm
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Dias da Semana',
                            font: {
                                size: 14 // Tamanho da fonte do título
                            }
                        },
                        ticks: {
                            font: {
                                size: 12 // Tamanho da fonte dos ticks
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
