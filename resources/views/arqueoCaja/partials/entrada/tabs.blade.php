<div class="mb-4 border-b border-gray-200 dark:border-gray-700 w-full">
    <ul class="flex flex-wrap w-full -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="cordobas-tab" data-tabs-target="#cordobas" type="button" role="tab" aria-controls="cordobas" aria-selected="false">Cordobas</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dolares-tab" data-tabs-target="#dolares" type="button" role="tab" aria-controls="dolares" aria-selected="false">Dolares</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="cheques-tab" data-tabs-target="#cheques" type="button" role="tab" aria-controls="cheques" aria-selected="false">Cheques</button>
        </li>

    </ul>
</div>
<div id="default-tab-content">
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="cordobas" role="tabpanel" aria-labelledby="cordobas-tab">
        @include('arqueoCaja.partials.entrada.cajaChicaEntradaCordoba')
    </div>
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dolares" role="tabpanel" aria-labelledby="dolares-tab">
        @include('arqueoCaja.partials.entrada.cajaChicaEntradaDolares')
    </div>
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="cheques" role="tabpanel" aria-labelledby="cheques-tab">
    @include('arqueoCaja.partials.entrada.cajaChicaEntradaCheque')
    </div>

</div>