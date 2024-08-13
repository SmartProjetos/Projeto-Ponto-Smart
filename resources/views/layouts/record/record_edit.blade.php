<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-bold mb-4">Editar Registro de Ponto</h2>
                    <form action="{{ route('record.update', $record->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data:</label>
                            <input type="date" name="date" id="date"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md"
                                value="{{ $record->date }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="entry_time"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hora de
                                Entrada:</label>
                            <input type="time" name="entry_time" id="entry_time"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md"
                                value="{{ $record->entry_time }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="departure_time"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hora de
                                Saída:</label>
                            <input type="time" name="departure_time" id="departure_time"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md"
                                value="{{ $record->departure_time }}">
                        </div>

                        <div class="mb-4">
                            <label for="total_hours"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total de
                                Horas:</label>
                            <input type="text" name="total_hours" id="total_hours"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md"
                                value="{{ $record->total_hours }}" readonly>
                        </div>

                        <div id="projects">
                            @for ($i = 1; $i <= 6; $i++)
                                <div id="projects-0{{ $i }}" style="display: none;"
                                    class="{{ $record->{'project' . $i . '_name'} ? '' : 'hidden' }} mb-4">
                                    <div class="mb-4">
                                        <label for="project{{ $i }}_name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Projeto
                                            {{ $i }}:</label>
                                        <select name="project{{ $i }}_name"
                                            id="project{{ $i }}_name"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md">
                                            <option value="">Selecione um Projeto</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->name }}"
                                                    {{ $record->{'project' . $i . '_name'} == $project->name ? 'selected' : '' }}>
                                                    {{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="project{{ $i }}_hours"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Horas no
                                            Projeto {{ $i }}:</label>
                                        <input type="time" name="project{{ $i }}_hours"
                                            id="project{{ $i }}_hours"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md"
                                            value="{{ $record->{'project' . $i . '_hours'} }}">
                                    </div>

                                    <div class="mb-4">
                                        <label for="project{{ $i }}_description"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição
                                            do Projeto {{ $i }}:</label>
                                        <textarea name="textarea{{ $i }}" id="textarea{{ $i }}"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md"
                                            rows="3">{{ $record->{'textarea' . $i} }}</textarea>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div class="mt-4 flex justify-end space-x-2">
                            <a href="{{ route('record.show', ['punch' => $record->id]) }}"
                                class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md">
                                Voltar
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Atualizar Registro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            function validateProjectHours(projectInput, nextProjectDiv, previousTotal) {
                const inputValor = projectInput.val();
                // projectInput.prop('required', true);
                const totalHoursInput = $('#total_hours').val();

                // Dividir o valor do input em horas e minutos
                const inputHorasMinutos = inputValor.split(':');
                const inputHoras = parseInt(inputHorasMinutos[0]);
                const inputMinutos = parseInt(inputHorasMinutos[1]);

                // Dividir o valor total de horas em horas e minutos
                const totalHorasMinutos = totalHoursInput.split(':');
                const totalHoras = parseInt(totalHorasMinutos[0]);
                const totalMinutos = parseInt(totalHorasMinutos[1]);

                // Converter ambos os tempos para minutos para comparação
                const inputTotalMinutos = inputHoras * 60 + inputMinutos;
                const totalAvailableMinutos = totalHoras * 60 + totalMinutos - previousTotal;

                // Log dos valores
                console.log("Horas e Minutos inseridos: " + inputHoras + ":" + inputMinutos);
                console.log("Total de Horas disponíveis: " + totalAvailableMinutos);

                // Comparação para verificar se o valor inserido excede o total de horas disponíveis
                if (inputTotalMinutos > totalAvailableMinutos) {
                    projectInput.val(''); // Limpar o valor do input inválido
                    alert('Total de horas no projeto excede o tempo disponível!');
                } else if (inputTotalMinutos < totalAvailableMinutos) {
                    nextProjectDiv.show(); // Mostrar a próxima div
                    // projectInput.prop('required', true);
                } else {
                    nextProjectDiv.hide(); // Esconder a próxima div se o tempo restante for zero
                }

                return inputTotalMinutos;
            }

            // Inicializa os projetos
            let project1TotalMinutes = 0;
            let project2TotalMinutes = 0;
            let project3TotalMinutes = 0;
            let project4TotalMinutes = 0;
            let project5TotalMinutes = 0;

            $('input[name="project1_hours"]').on('input', function() {
                $(this).prop('required', true)
                const projectsDiv02 = $('#projects-02');
                project1TotalMinutes = validateProjectHours($(this), projectsDiv02, 0);
                showNextIfNotEmpty($(this), $('input[name="project2_hours"]'));
            });

            $('input[name="project2_hours"]').on('input', function() {
                $(this).attr('required', true)
                const projectsDiv03 = $('#projects-03');
                project2TotalMinutes = validateProjectHours($(this), projectsDiv03, project1TotalMinutes);
                showNextIfNotEmpty($(this), $('input[name="project3_hours"]'));
            });

            $('input[name="project3_hours"]').on('input', function() {
                $(this).attr('required', true)
                const projectsDiv04 = $('#projects-04');
                project3TotalMinutes = validateProjectHours($(this), projectsDiv04, project1TotalMinutes +
                    project2TotalMinutes);
                showNextIfNotEmpty($(this), $('input[name="project4_hours"]'));
            });

            $('input[name="project4_hours"]').on('input', function() {
                const projectsDiv05 = $('#projects-05');
                project4TotalMinutes = validateProjectHours($(this), projectsDiv05, project1TotalMinutes +
                    project2TotalMinutes + project3TotalMinutes);
                showNextIfNotEmpty($(this), $('input[name="project5_hours"]'));
            });

            $('input[name="project5_hours"]').on('input', function() {
                const projectsDiv06 = $('#projects-06');
                project5TotalMinutes = validateProjectHours($(this), projectsDiv06, project1TotalMinutes +
                    project2TotalMinutes + project3TotalMinutes + project4TotalMinutes);
                showNextIfNotEmpty($(this), $('input[name="project6_hours"]'));
            });

            $('input[name="project6_hours"]').on('input', function() {
                validateProjectHours($(this), $(), project1TotalMinutes + project2TotalMinutes +
                    project3TotalMinutes + project4TotalMinutes + project5TotalMinutes);
            });

            function calculateTotalHours() {
                const punchedInAt = $('#entry_time').val();
                const punchedOutAt = $('#departure_time').val();
                const totalHoursInput = $('#total_hours');
                const projectsDiv = $('#projects-01');

                if (punchedInAt && punchedOutAt) {
                    const inTime = new Date(`1970-01-01T${punchedInAt}`);
                    const outTime = new Date(`1970-01-01T${punchedOutAt}`);
                    const diff = outTime - inTime;
                    const hours = Math.floor(diff / 1000 / 60 / 60);
                    const minutes = Math.floor((diff / 1000 / 60) % 60);

                    totalHoursInput.val(`${hours}:${minutes < 10 ? '0' : ''}${minutes}`);
                    projectsDiv.toggle(hours > 0 || minutes > 0);
                } else {
                    totalHoursInput.val('');
                    projectsDiv.hide();
                }
            }

            $('#entry_time, #departure_time').on('input', calculateTotalHours);

            function showNextIfNotEmpty(currentInput, nextInput) {
                if (currentInput.val()) {
                    nextInput.closest('.mb-4').show();
                }
            }
        });
    </script>
</x-app-layout>
