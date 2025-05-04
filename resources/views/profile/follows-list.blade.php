@extends("layouts.site")
@section('title', 'Perfil')

@section('content')
    <main class="w-7xl mx-auto px-6 mt-10">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded border border-green-300 mb-2">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded border border-red-300 mb-2">
                {{ session('error') }}
            </div>
        @endif
        <div>
            <!-- Posts section -->
            <section>
                <div>
                    <div class="flex items-center gap-6">
                        <img src="{{ !$user->cover_path ? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=009966&color=fff' : asset('storage/' . $user->cover_path)  }}"
                            class="w-24 h-24 rounded-full object-cover" alt="avatar">
                        <div>
                            <h1 class="text-2xl font-bold">{{ $user->name }}
                                @if ($loggedUserID == $user->id)
                                    <a href="{{ route("profile.edit", $user->username) }}"
                                        class="text-sm text-gray-500 hover:text-emerald-600"><i class="fas fa-pencil"></i>
                                        Editar Perfil</a>
                                @endif
                            </h1>

                            <p class="text-gray-500">{{ $user->bio }}</p>
                            </p>
                            <p class="mt-2 text-sm text-gray-400">Membro {{ $user->created_at->diffForHumans() }}</p>
                            <div class="flex items-center mt-4 gap-x-4">
                                <a href="{{ route('profile.following', $user->username) }}" class="text-sm text-gray-500 hover:text-emerald-600"><i
                                        class="fas fa-user-friends mr-1"></i> Seguindo <span
                                        class="font-semibold">{{ $user->following_count }}</span></a>
                                @livewire('follow-count', ['user' => $user])
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">

                    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
                    @if ($followList->isEmpty())
                        <p class="text-gray-500">Ainda não tem ninguem aqui.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($followList as $followedUser)
                                <li class="flex items-center gap-4">
                                    <img src="{{ !$followedUser->cover_path ? 'https://ui-avatars.com/api/?name=' . urlencode($followedUser->name) . '&background=009966&color=fff' : asset('storage/' . $followedUser->cover_path) }}"
                                        class="w-16 h-16 rounded-full object-cover" alt="avatar">
                                    <div>
                                        <a href="{{ route('profile.show', $followedUser->username) }}" class="text-lg font-semibold hover:text-emerald-600">{{ $followedUser->name }}</a>
                                        <p class="text-gray-500">{{ $followedUser->bio }}</p>
                                        <p class="mt-2 text-sm text-gray-400">Membro
                                            {{ $followedUser->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="ml-auto">
                                        @livewire('follow-action', ['user' => $followedUser])
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="mt-4">
                        {{ $followList->links() }}
                    </div>
                </div>

            </section>
        </div>
    </main>
@endsection