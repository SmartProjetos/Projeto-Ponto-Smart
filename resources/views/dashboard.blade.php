<x-app-layout>
    <!-- Data Tables -->
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8 pt-06">Funcionários Cadastrados
        </h1>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Avatar</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                User</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Email</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Tipo de Acesso</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($users as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if (in_array($item->name, ['Eloiza Tochio', 'Maria Eduarda']))
                                        <img class="h-10 w-10 rounded-full"
                                            src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar">
                                    @else
                                        <img class="h-10 w-10 rounded-full"
                                            src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar">
                                    @endif
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-xl text-gray-500 dark:text-gray-200 text-truncate">
                                    {{ $item->name }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-xl text-gray-500 dark:text-gray-200 text-truncate">
                                    {{ $item->email }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-xl text-gray-500 dark:text-gray-200 text-truncate">
                                    <i class="mdi mdi-{{ $item->role_icon }} mdi-24px mr-1"></i> {{ $item->role }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- <div class="container mx-auto py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8">Histórico de Registro de
                Pontos
            </h1>
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @foreach ($record->groupBy('user_id') as $userId => $userRecords)
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">
                        {{ $userRecords->first()->user->username }}</h2>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mb-8">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Data
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Entrada
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Saída
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Total de Horas
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Mais informação
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($userRecords as $punch)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($punch->date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($punch->entry_time)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $punch->departure_time ? \Carbon\Carbon::parse($punch->departure_time)->format('H:i') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $punch->total_hours ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        <a href="{{ route('record.show', $punch->id) }}"
                                            class="text-blue-500 hover:text-blue-700">Visualizar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>
 --}}


</x-app-layout>
