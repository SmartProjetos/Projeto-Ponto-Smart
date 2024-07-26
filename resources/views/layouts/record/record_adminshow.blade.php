<x-app-layout>
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
                        <div class="grid grid-cols-2 gap-x-4">
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
                                <div>
                                    <span class="font-bold">Projeto 1:</span>
                                </div>
                                <div>
                                    {{ $punch->project1_name }} -
                                    {{ \Carbon\Carbon::parse($punch->project1_hours)->format('H:i') }} Hr
                                </div>
                            @endif
                            @if ($punch->project2_name && $punch->project2_hours)
                                <div>
                                    <span class="font-bold">Projeto 2:</span>
                                </div>
                                <div>
                                    {{ $punch->project2_name }} -
                                    {{ \Carbon\Carbon::parse($punch->project2_hours)->format('H:i') }} Hr
                                </div>
                            @endif
                            @if ($punch->project3_name && $punch->project3_hours)
                                <div>
                                    <span class="font-bold">Projeto 3:</span>
                                </div>
                                <div>
                                    {{ $punch->project3_name }} -
                                    {{ \Carbon\Carbon::parse($punch->project3_hours)->format('H:i') }} Hr
                                </div>
                            @endif
                            @if ($punch->project4_name && $punch->project4_hours)
                                <div>
                                    <span class="font-bold">Projeto 4:</span>
                                </div>
                                <div>
                                    {{ $punch->project4_name }} -
                                    {{ \Carbon\Carbon::parse($punch->project4_hours)->format('H:i') }} Hr
                                </div>
                            @endif
                            @if ($punch->project5_name && $punch->project5_hours)
                                <div>
                                    <span class="font-bold">Projeto 5:</span>
                                </div>
                                <div>
                                    {{ $punch->project5_name }} -
                                    {{ \Carbon\Carbon::parse($punch->project5_hours)->format('H:i') }} Hr
                                </div>
                            @endif
                            @if ($punch->project6_name && $punch->project6_hours)
                                <div>
                                    <span class="font-bold">Projeto 6:</span>
                                </div>
                                <div>
                                    {{ $punch->project6_name }} -
                                    {{ \Carbon\Carbon::parse($punch->project6_hours)->format('H:i') }} Hr
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Linha decorativa -->
                    <div class="border-t border-gray-300 my-4"></div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('user.index', $user_id->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>