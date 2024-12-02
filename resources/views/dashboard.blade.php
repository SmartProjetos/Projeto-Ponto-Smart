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
                                <img src="{{ auth()->user()->profile_image_path ? asset('storage/' . auth()->user()->profile_image_path) : 'https://via.placeholder.com/150' }}"
                                    alt="Foto do Perfil"
                                    class="w-32 h-32 mx-auto rounded-full border-4 border-blue-600 dark:border-blue-400 shadow-md">
                            </label>
                            <input id="avatar" name="avatar" type="file" class="hidden" accept="image/*"
                                onchange="this.form.submit()">
                        </form>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-4">
                            {{ auth()->user()->name }}
                        </h1>
                    </div>
                </div>

                <!-- Coluna Direita: Informações do Usuário -->
                <div class="w-full md:w-2/3 mt-6 md:mt-0 md:pl-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8 pt-6">
                            Informações do Usuário
                        </h1>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 border rounded-lg shadow-sm">
                                <label class="block text-gray-600 dark:text-gray-300 font-medium">Nome</label>
                                <p class="text-gray-800 dark:text-gray-100">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="p-4 border rounded-lg shadow-sm">
                                <label class="block text-gray-600 dark:text-gray-300 font-medium">E-mail</label>
                                <p class="text-gray-800 dark:text-gray-100">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="p-4 border rounded-lg shadow-sm">
                                <label class="block text-gray-600 dark:text-gray-300 font-medium">Tipo de
                                    Contrato</label>
                                <p class="text-gray-800 dark:text-gray-100">
                                    @php
                                        $typeOfEmployee = auth()->user()->type_of_employee ?? 'N/A';
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
                                    @if (auth()->user()->role === 'funcionarios')
                                        Colaborador
                                    @elseif(auth()->user()->role === 'administrativo')
                                        Gerente
                                    @elseif(auth()->user()->role === 'master')
                                        Desenvolvedor
                                    @else
                                        {{ auth()->user()->role }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mt-6">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8 pt-6">
                Seus Horários
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
                Histórico de Horas
            </h1>

            <!-- Gráfico Chart.js -->
            <div class="overflow-hidden">
                <canvas id="hoursChart"></canvas>
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
</x-app-layout>
