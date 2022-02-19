<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">

    <div class="p-6 border border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <img class="w-10" src="{{ URL::asset('images/client.png') }}" alt="client">
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                <a href="{{ url('client') }}">Liste des clients</a>
            </div>
        </div>
        <div class="ml-12">
            <a href="{{ url('client') }}">
                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                    <div>Liste des clients</div>
                    <div class="ml-1 text-indigo-500">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="p-6 border border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
                <img class="w-10" src="{{ URL::asset('images/questionnaire.png') }}" alt="client">
                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                    <a href="{{ route('questionnaire.listing') }}">Liste des questionnaires</a>
                </div>
        </div>
        <div class="ml-12">
            <a href="{{ route('questionnaire.listing') }}">
                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                    <div>Voir la liste des questionnaires</div>
                    <div class="ml-1 text-indigo-500">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="text-red-600">
        
    </div>

</div>
