<div>
    <ul class="space-y-2">
        @forelse ($user->followers as $follower)
            <li class="flex items-center gap-2">
                <a href="{{ route('profile.show', $follower->username) }}"
                    class="w-full flex items-center gap-2 hover:bg-gray-100 p-2 rounded-lg transition dark:hover:bg-neutral-800">
                    <img src="{{ !$follower->cover_path ? 'https://ui-avatars.com/api/?name=' . urlencode($follower->name) . '&background=009966&color=fff' : asset('storage/' . $follower->cover_path)  }}"
                        alt="Avatar" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="text-sm font-semibold">{{ $follower->name }}</p>
                        <p class="text-xs text-gray-500">Membro {{ $follower->created_at->diffForHumans() }}</p>
                    </div>
                </a>
            </li>
        @empty
            <li class="text-gray-500">Nenhum seguidor encontrado.</li>
        @endforelse
    </ul>
</div>
