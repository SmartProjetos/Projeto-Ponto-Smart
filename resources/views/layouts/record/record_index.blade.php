<x-app-layout>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center text-gray-900 mb-8">
            Histórico de Registro de Pontos de {{ auth()->user()->name }}
        </h1>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase w-1/4">Data... </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Entrada</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Saída</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Total de Horas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedRecords as $date => $records)
                            <tr>
                                <td colspan="5" class="bg-gray-100 text-left font-bold py-2">{{ $date }}</td>
                            </tr>
                            @foreach ($records as $punch)
                                <tr onclick="window.location.href='{{ route('record.show', $punch->id) }}'"
                                    class="cursor-pointer">
                                    <td class="px-6 py-4 text-sm w-1/4">       </td>
                                    <td class="px-6 py-4 text-sm">
                                        {{ \Carbon\Carbon::parse($punch->entry_time)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        {{ $punch->departure_time ? \Carbon\Carbon::parse($punch->departure_time)->format('H:i') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $punch->total_hours ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('record.destroy', $punch->id) }}"
                                            onclick="return confirm('Tem certeza que deseja excluir este registro?')"
                                            class="inline-flex
                                            items-center px-4 py-2 bg-red-500 border border-transparent rounded-md
                                            font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700
                                            active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring
                                            ring-red-300 disabled:opacity-25 transition ease-in-out
                                            duration-150">Excluir</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
