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


    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center text-gray-800 dark:text-gray-200">
            Detalhes do Registro de Ponto
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold mb-2">Informações do Registro</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
                            <div>
                                <span class="font-bold">Data:</span>
                            </div>
                            <div>
                                {{ \Carbon\Carbon::parse($punch->date)->format('d/m/Y') }}
                            </div>

                            <div>
                                <span class="font-bold">Hora de Entrada:</span>
                            </div>
                            <div>
                                {{ \Carbon\Carbon::parse($punch->entry_time)->format('H:i') }}
                            </div>

                            <div>
                                <span class="font-bold">Hora de Saída:</span>
                            </div>
                            <div>
                                @if (isset($punch->departure_time) && !empty($punch->departure_time))
                                    {{ \Carbon\Carbon::parse($punch->departure_time)->format('H:i') }}
                                @else
                                    --:--
                                @endif
                            </div>

                            <div>
                                <span class="font-bold">Total de Horas:</span>
                            </div>
                            <div>
                                {{ $punch->total_hours }}
                            </div>

                            @if ($punch->project1_name && $punch->project1_hours)
                                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        Projeto 1:
                                    </div>
                                    <div class="text-gray-700 dark:text-gray-300 mt-1">
                                        {{ $punch->project1_name }} -
                                        {{ \Carbon\Carbon::parse($punch->project1_hours)->format('H:i') }} Hr
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-gray-700 dark:text-gray-300">
                                            Descrição do Projeto 1: {{ $punch->textarea1 }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($punch->project2_name && $punch->project2_hours)
                                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        Projeto 2:
                                    </div>
                                    <div class="text-gray-700 dark:text-gray-300 mt-1">
                                        {{ $punch->project2_name }} -
                                        {{ \Carbon\Carbon::parse($punch->project2_hours)->format('H:i') }} Hr
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-gray-700 dark:text-gray-300">
                                            Descrição do Projeto 2: {{ $punch->textarea2 }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($punch->project3_name && $punch->project3_hours)
                                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        Projeto 3:
                                    </div>
                                    <div class="text-gray-700 dark:text-gray-300 mt-1">
                                        {{ $punch->project3_name }} -
                                        {{ \Carbon\Carbon::parse($punch->project3_hours)->format('H:i') }} Hr
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-gray-700 dark:text-gray-300">
                                            Descrição do Projeto 3: {{ $punch->textarea3 }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($punch->project4_name && $punch->project4_hours)
                                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        Projeto 4:
                                    </div>
                                    <div class="text-gray-700 dark:text-gray-300 mt-1">
                                        {{ $punch->project4_name }} -
                                        {{ \Carbon\Carbon::parse($punch->project4_hours)->format('H:i') }} Hr
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-gray-700 dark:text-gray-300">
                                            Descrição do Projeto 4: {{ $punch->textarea4 }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($punch->project5_name && $punch->project5_hours)
                                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        Projeto 5:
                                    </div>
                                    <div class="text-gray-700 dark:text-gray-300 mt-1">
                                        {{ $punch->project5_name }} -
                                        {{ \Carbon\Carbon::parse($punch->project5_hours)->format('H:i') }} Hr
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-gray-700 dark:text-gray-300">
                                            Descrição do Projeto 5: {{ $punch->textarea5 }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($punch->project6_name && $punch->project6_hours)
                                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        Projeto 6:
                                    </div>
                                    <div class="text-gray-700 dark:text-gray-300 mt-1">
                                        {{ $punch->project6_name }} -
                                        {{ \Carbon\Carbon::parse($punch->project6_hours)->format('H:i') }} Hr
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-gray-700 dark:text-gray-300">
                                            Descrição do Projeto 6: {{ $punch->textarea6 }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Linha decorativa -->
                    <div class="border-t border-gray-300 my-4"></div>
                    <div class="mt-6 flex flex-col sm:flex-row justify-end gap-2">
                        <a href="{{ route('record.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Voltar
                        </a>
                        <a href="{{ route('record.edit', $punch->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Editar
                        </a>
                        <a href="{{ route('record.destroy', $punch->id) }}"
                            onclick="event.preventDefault(); confirmDelete('{{ route('record.destroy', $punch->id) }}');"
                            class="inline-flex items-center px-4 py-2 bg-red-500 dark:bg-red-700 border border-transparent rounded-md
                                   font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none
                                   focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Excluir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(url) {
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
    </script>
</x-app-layout>
