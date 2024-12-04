<x-app-layout>
    <div class="container mx-auto py-6">
        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-wrap md:flex-nowrap p-6 items-center">
                <!-- Coluna Esquerda: Foto do Perfil -->
                <div class="flex-shrink-0 w-full md:w-1/3 text-center md:border-r dark:border-gray-700">
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                        <form action="{{ route('user.updateAvatar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <label for="avatar" class="cursor-pointer">
                                <img src="{{ $user->profile_image_path ? asset('storage/' . $user->profile_image_path) : 'https://via.placeholder.com/150' }}"
                                    alt="Foto do Perfil"
                                    class="w-32 h-32 mx-auto rounded-full border-4 border-blue-600 dark:border-blue-400 shadow-md">
                            </label>
                            <input id="avatar" name="avatar" type="file" class="hidden" accept="image/*"
                                onchange="this.form.submit()">
                        </form>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-4">
                            {{ $user->name }}
                        </h1>
                    </div>
                </div>

                <!-- Coluna Direita: Informações do Usuário -->
                <div class="w-full md:w-2/3 mt-6 md:mt-0 md:pl-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8 pt-6">
                            Informações do Funcionário
                        </h1>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 border rounded-lg shadow-sm">
                                <label class="block text-gray-600 dark:text-gray-300 font-medium">Nome</label>
                                <p class="text-gray-800 dark:text-gray-100">{{ $user->name }}</p>
                            </div>
                            <div class="p-4 border rounded-lg shadow-sm">
                                <label class="block text-gray-600 dark:text-gray-300 font-medium">E-mail</label>
                                <p class="text-gray-800 dark:text-gray-100">{{ $user->email }}</p>
                            </div>
                            <div class="p-4 border rounded-lg shadow-sm">
                                <label class="block text-gray-600 dark:text-gray-300 font-medium">Tipo de
                                    Contrato</label>
                                <p class="text-gray-800 dark:text-gray-100">
                                    @php
                                        $typeOfEmployee = $user->type_of_employee ?? 'N/A';
                                        $typeLabels = [
                                            'bolsista' => 'Bolsista',
                                            'CLT' => 'CLT',
                                            'CLT mais bolsista' => 'CLT mais Bolsa',
                                            'estagio' => 'Estágio',
                                            'estagio mais bolsista' => 'Estágio mais Bolsa',
                                            'consultoria' => 'Consultoria',
                                            'outros' => 'Outros',
                                        ];
                                    @endphp

                                    {{ $typeLabels[$typeOfEmployee] ?? $typeOfEmployee }}
                                </p>
                            </div>

                            <div class="p-4 border rounded-lg shadow-sm">
                                <label class="block text-gray-600 dark:text-gray-300 font-medium">Acesso</label>
                                <p class="text-gray-800 dark:text-gray-100">
                                    @if ($user->role === 'funcionarios')
                                        Colaborador
                                    @elseif($user->role === 'administrativo')
                                        Gerente
                                    @elseif($user->role === 'master')
                                        Desenvolvedor
                                    @else
                                        {{ $user->role }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mt-6">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8">
               Hora Extre de {{ $user->name }}
            </h1>

            <div class="flex flex-wrap md:flex-nowrap p-6 items-start text-center">
                <div class="left-column flex-1 pr-6">
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Carga Horária Semanal
                        </h2>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $user_week }}
                        </p>
                    </div>
                </div>

                <div class="right-column flex-1">
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Horas Extras Da Semana
                        </h2>
                        <p
                            class="text-2xl font-bold {{ $weeklyBalance['sign'] == '(débito)' ? 'text-red-500 dark:text-red-400' : 'text-green-500 dark:text-green-400' }}">
                            {{ $weeklyBalance['value'] }} {{ $weeklyBalance['sign'] }}
                            <!-- Valor das horas extras com formato -->
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Contêiner para o título e gráfico -->
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mt-6">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8 pt-6">
                Histórico de Horas de {{ $user->name }}
            </h1>

            <!-- Gráfico Chart.js -->
            <div class="overflow-hidden">
                <canvas id="hoursChart"></canvas>
            </div>
        </div>
    </div>

    <div class="container mx-auto py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 overflow-x-auto">
                <!-- Dropdown Button -->
                <form action="{{ route('user.store', $user->id) }}" method="POST"
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
        // Dados para o gráfico (passados do controlador)
        var months = @json($months); // Meses
        var totalMinutes = @json($totalMinutes); // Total de minutos por mês

        // Criar o gráfico
        var ctx = document.getElementById('hoursChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar', // Tipo do gráfico: coluna (bar)
            data: {
                labels: months, // Rótulos para os meses
                datasets: [{
                    label: 'Horas Trabalhadas',
                    data: totalMinutes, // Usando minutos como dados numéricos
                    backgroundColor: '#4C9AFF', // Cor azul para as colunas
                    borderColor: '#3182CE', // Cor de borda das colunas
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Callback para formatar os ticks do eixo Y
                            callback: function(value) {
                                var hours = Math.floor(value / 60);
                                var minutes = value % 60;
                                return hours + 'h ' + (minutes < 10 ? '0' : '') + minutes +
                                    'm'; // Exibir como "Xh Ym"
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            // Formatar os valores exibidos no tooltip
                            label: function(context) {
                                var value = context.raw; // Valor original
                                var hours = Math.floor(value / 60);
                                var minutes = value % 60;
                                return hours + 'h ' + (minutes < 10 ? '0' : '') + minutes +
                                    'm'; // Exibir como "Xh Ym"
                            }
                        }
                    }
                }
            }
        });
    </script>


    <!-- SweetAlert2 Script -->
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Imagem de Perfil Atualizada!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Ok'
            });
        @endif
    </script>

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

</x-app-layout>
