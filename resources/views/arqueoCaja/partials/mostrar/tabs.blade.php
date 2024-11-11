<div class="grid grid-cols-2 gap-4">
    <div>
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700 w-full">
            <ul class="flex flex-wrap w-full -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Cordobas</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Dolares</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Cheques</button>
                </li>

            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                @include('arqueoCaja.partials.mostrar.cajaChicaCordobas')
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                @include('arqueoCaja.partials.mostrar.cajaChicaDolares')
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
            @include('arqueoCaja.partials.mostrar.cajaChicaCheques')
            </div>

        </div>
    </div>


    <div class="w-full text-center mt-4 p-10">
        <div class="grid w-full">
            <div>
                <p>Acciones de Caja Chica</p> 
            </div>
            <div>
                @include('arqueoCaja.partials.entrada.cajaChicaEntrada')
            </div>
        </div>


        <p class="text-2xl font-semibold text-gray-700">
            Movimientos
        </p>
        <div class="mt-2 w-full h-full bg-gray-100 rounded-lg">

        </div>
    </div>

</div>

