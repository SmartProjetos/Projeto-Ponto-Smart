<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-bold mb-4">Registrar Ponto</h2>
                    <form action="{{ route('record.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        <div class="mb-4">
                            <label for="date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data:</label>
                            <input type="date" name="date" id="date"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="entry_time"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hora de
                                Entrada:</label>
                            <input type="time" name="entry_time" id="entry_time"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="departure_time"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hora de
                                Saída:</label>
                            <input type="time" name="departure_time" id="departure_time"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="total_hours"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total de
                                Horas:</label>
                            <input type="text" name="total_hours" id="total_hours"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md"
                                readonly>
                        </div>

                        <div id="projects">
                            @for ($i = 1; $i <= 6; $i++)
                                <div id="projects-0{{ $i }}" style="display: none;">
                                    <div class="mb-4">
                                        <label for="project{{ $i }}_name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Projeto
                                            {{ $i }}:</label>
                                        <select name="project{{ $i }}_name"
                                            id="project{{ $i }}_name"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md">
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->name }}">{{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="project{{ $i }}_hours"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Horas no
                                            Projeto {{ $i }}:</label>
                                        <input type="time" name="project{{ $i }}_hours"
                                            id="project{{ $i }}_hours"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 sm:text-sm rounded-md">
                                    </div>

                                    <div class="mb-4">
                                        <label for="textarea{{ $i }}"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descrição
                                            das Atividades:</label>
                                        <textarea id="textarea{{ $i }}" name="textarea{{ $i }}" rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Escreva aqui..."></textarea>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('record.index') }}"
                                class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md">
                                Voltar
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Registrar
                                Ponto</button>
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
                const inputTotalMinutos = (inputHoras * 60) + inputMinutos;
                const totalAvailableMinutos = (totalHoras * 60) + totalMinutos - previousTotal;

                // Log dos valores
                console.log("Horas e Minutos inseridos: " + inputHoras + ":" + inputMinutos);
                console.log("Total de Horas disponíveis: " + totalAvailableMinutos);

                // Comparação para verificar se o valor inserido excede o total de horas disponíveis
                if (inputTotalMinutos > totalAvailableMinutos) {
                    projectInput.val(''); // Limpar o valor do input inválido
                    alert('Total de horas no projeto excede o tempo disponível!');
                }

                // Mostrar a próxima div se o valor inserido for válido e houver tempo restante
                if (inputTotalMinutos < totalAvailableMinutos) {
                    nextProjectDiv.show(); // Mostrar a próxima div
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
                const projectsDiv02 = $('#projects-02');
                project1TotalMinutes = validateProjectHours($(this), projectsDiv02, 0);
            });

            $('input[name="project2_hours"]').on('input', function() {
                const projectsDiv03 = $('#projects-03');
                project2TotalMinutes = validateProjectHours($(this), projectsDiv03, project1TotalMinutes);
            });

            $('input[name="project3_hours"]').on('input', function() {
                const projectsDiv04 = $('#projects-04');
                project3TotalMinutes = validateProjectHours($(this), projectsDiv04, project1TotalMinutes +
                    project2TotalMinutes);
            });

            $('input[name="project4_hours"]').on('input', function() {
                const projectsDiv05 = $('#projects-05');
                project4TotalMinutes = validateProjectHours($(this), projectsDiv05, project1TotalMinutes +
                    project2TotalMinutes + project3TotalMinutes);
            });

            $('input[name="project5_hours"]').on('input', function() {
                const projectsDiv06 = $('#projects-06');
                project5TotalMinutes = validateProjectHours($(this), projectsDiv06, project1TotalMinutes +
                    project2TotalMinutes + project3TotalMinutes + project4TotalMinutes);
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
        });
    </script>
    <script>
        $(document).ready(function() {
            // Pegar a data e hora atuais
            var now = new Date();

            // Formatando a data no formato YYYY-MM-DD
            var formattedDate = now.toISOString().slice(0, 10);
            $('#date').val(formattedDate);

            // Formatando a hora no formato HH:MM
            var formattedTime = now.toTimeString().slice(0, 5);
            $('#entry_time').val(formattedTime);
        });
    </script>
</x-app-layout>
