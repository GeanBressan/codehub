<div>
    <h3 class="text-lg font-semibold mb-4 text-gray-800"><i class="fas fa-comments mr-2"></i>Comentários
        <span class="text-sm text-gray-500">({{ count($comments) }})</span>
    </h3>
    <p class="text-gray-600 text-sm mb-4">Deixe seu comentário e compartilhe sua opinião!</p>
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded border border-green-300 mb-4">
            {{ session('message') }}
        </div>
    @endif
    <form class="flex flex-col gap-3" wire:submit.prevent="addComment">
        <textarea rows="4" placeholder="Escreva seu comentário..." wire:model="content"
            class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
        @error('content')
            <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
        <button class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">Enviar</button>
    </form>
    @if (count($comments) > 0)
        <div class="mt-6">
            <h4 class="text-lg font-semibold mb-2 text-gray-800"><i class="fas fa-comments mr-2"></i>Comentários
            </h4>
            <ul class="space-y-4">
                @foreach ($comments as $comment)
                    <li class="bg-gray-200 p-4 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <img src="{{ !$comment->user->cover_path ? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=009966&color=fff' : asset('storage/' . $comment->user->cover_path)  }}" alt="{{ $comment->user->name }}"
                                class="w-10 h-10 rounded-full">
                            <h5 class="text-sm font-semibold text-gray-800">{{ $comment->user->name }}</h5>
                            <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                            @if ($comment->user->id === auth()->user()->id)
                                <button class="text-red-500 hover:text-red-700 text-xs ml-auto" wire:click="deleteComment({{$comment->id}})">Excluir</button>
                            @endif
                        </div>
                        <div class="border-b border-gray-300 my-4"></div>
                        <div class="text-sm text-gray-600">
                            <p>{{ $comment->content }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
