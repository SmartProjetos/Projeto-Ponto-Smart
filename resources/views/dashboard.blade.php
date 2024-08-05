<x-app-layout>
    <!-- Data Tables -->
    <div class="container mx-auto py-3">
        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8 pt-6">
            Funcionários Cadastrados
        </h1>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-1">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Avatar
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                User
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Email
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Horas Trabalhadas na Semana
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Tipo de Acesso
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr onclick="window.location.href='{{ route('user.index', $item->id) }}'"
                                class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
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
                                    class="px-6 py-4 whitespace-nowrap text-center text-xl text-gray-500 dark:text-gray-200 text-truncate">
                                    {{ $hoursPerWeekByUser[$item->name] }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-center text-xl text-gray-500 dark:text-gray-200 text-truncate">
                                    <i class="mdi mdi-{{ $item->role_icon }} mdi-24px mr-1"></i>
                                    @if ($item->role == 'funcionarios')
                                        Colaborador
                                    @elseif ($item->role == 'administrativo')
                                        Gerente
                                    @elseif ($item->role == 'master')
                                        Desenvolvedor
                                    @else
                                        {{ $item->role }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
