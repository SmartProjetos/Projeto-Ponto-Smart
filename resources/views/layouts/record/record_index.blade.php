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
        </h1>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
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
                                <span class="inline">Entrada</span>
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500 dark:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span class="inline">Saida</span>
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500 dark:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span class="inline">Total de Horas</span>
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500 dark:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                <span class="inline">Ações</span>
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
                                    class="cursor-pointer">
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
    </script>
</x-app-layout>
