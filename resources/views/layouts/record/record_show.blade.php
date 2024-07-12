<x-app-layout>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhes do Registro de Ponto
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold mb-2">Informações do Registro</h3>
                        <ul class="list-none mb-0">
                            <li class="mb-2">
                                <span class="font-bold">Data:</span>
                                {{ \Carbon\Carbon::parse($punch->date)->format('d/m/Y') }}
                            </li>
                            <li class="mb-2">
                                <span class="font-bold">Hora de Entrada:</span>
                                {{ \Carbon\Carbon::parse($punch->entry_time)->format('H:i') }}
                            </li>
                            <li class="mb-2">
                                <span class="font-bold">Hora de Saída:</span>
                                {{ \Carbon\Carbon::parse($punch->departure_time)->format('H:i') }}
                            </li>
                            <li class="mb-2">
                                <span class="font-bold">Total de Horas:</span> {{ $punch->total_hours }}
                            </li>
                            <li class="mb-2">
                                <span class="font-bold">Projeto 1:</span> {{ $punch->project1_name }} -
                                {{ \Carbon\Carbon::parse($punch->project1_hours)->format('H:i') }}
                            </li>
                            <li class="mb-2">
                                <span class="font-bold">Projeto 2:</span> {{ $punch->project2_name }} -
                                {{ \Carbon\Carbon::parse($punch->project2_hours)->format('H:i') }}
                            </li>
                            <li class="mb-2">
                                <span class="font-bold">Projeto 3:</span> {{ $punch->project3_name }} -
                                {{ \Carbon\Carbon::parse($punch->project3_hours)->format('H:i') }}
                            </li>
                            <li class="mb-2">
                                <span class="font-bold">Projeto 4:</span> {{ $punch->project4_name }} -
                                {{ \Carbon\Carbon::parse($punch->project4_hours)->format('H:i') }}
                            </li>
                            <li class="mb-2">
                                <span class="font-bold">Projeto 5:</span> {{ $punch->project5_name }} -
                                {{ \Carbon\Carbon::parse($punch->project5_hours)->format('H:i') }}
                            </li>
                            <li class="mb-2">
                                <span class="font-bold">Projeto 6:</span> {{ $punch->project6_name }} -
                                {{ \Carbon\Carbon::parse($punch->project6_hours)->format('H:i') }}
                            </li>
                        </ul>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('record.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Voltar
                        </a>
                        <a href="{{ route('record.edit', $punch->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Editar
                        </a>
                        <a href="{{ route('record.destroy', $punch->id) }}"
                            onclick="return confirm('Tem certeza que deseja excluir este registro?')"
                            class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Excluir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
