<div class="relative">
    <div class="relative w-full">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 dark:text-gray-300"></i>
        <input type="text" placeholder="Pesquisar..." wire:model.live.debounce.500ms="search"
            class="border border-gray-300 rounded-lg px-8 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600 dark:text-white">
    </div>
    
    <div class="overflow-hidden absolute top-0 left-0 mt-12 w-full bg-white border border-gray-200 rounded-lg shadow-lg z-50 dark:bg-neutral-800 dark:border-neutral-700 {{ $search ? 'block' : 'hidden' }}">
        <div class="flex items-center justify-between p-4">
            <span class="text-sm text-gray-500 dark:text-gray-300">Resultados para "{{ $search }}"</span>
        </div>
        <div class="border-b border-gray-200 dark:border-neutral-700"></div>
        @if(count($searchResults) == 0)
            <p class="p-4 text-gray-500 dark:text-gray-300">Nenhum resultado encontrado.</p>
        @else
            <ul class="max-h-60 overflow-y-auto">
                @foreach($searchResults as $searchResult)
                    <li class="border-b border-gray-200 p-4 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:border-neutral-700">
                        <a href="{{ route('post.show', $searchResult->slug) }}" class="text-sm text-gray-800 hover:text-emerald-600 dark:text-white dark:hover:text-emerald-600">{{ $searchResult->title }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
