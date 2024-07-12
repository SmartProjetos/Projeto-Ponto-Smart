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
                        <p><span class="font-bold">Data:</span> {{ $punch->date }}</p>
                        <p><span class="font-bold">Hora de Entrada:</span> {{ $punch->entry_time }}</p>
                        <p><span class="font-bold">Hora de Saída:</span> {{ $punch->departure_time }}</p>
                        <p><span class="font-bold">Total de Horas:</span> {{ $punch->total_hours }}</p>
                        <p><span class="font-bold">Projeto 1:</span> {{ $punch->project1_name }} -
                            {{ $punch->project1_hours }}</p>
                        <p><span class="font-bold">Projeto 2:</span> {{ $punch->project2_name }} -
                            {{ $punch->project2_hours }}</p>
                        <p><span class="font-bold">Projeto 3:</span> {{ $punch->project3_name }} -
                            {{ $punch->project3_hours }}</p>
                        <p><span class="font-bold">Projeto 4:</span> {{ $punch->project4_name }} -
                            {{ $punch->project4_hours }}</p>
                        <p><span class="font-bold">Projeto 5:</span> {{ $punch->project5_name }} -
                            {{ $punch->project5_hours }}</p>
                        <p><span class="font-bold">Projeto 6:</span> {{ $punch->project6_name }} -
                            {{ $punch->project6_hours }}</p>

                    </div>
                    <div class="mt-6">
                        <a href="{{ route('record.index') }}"
                            class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md mr-2">Voltar
                            para a Lista</a>
                        <a href="{{ route('record.edit', $punch->id) }}"
                            class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">Editar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
