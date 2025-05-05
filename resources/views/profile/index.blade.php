@extends("layouts.site")
@section('title', 'Perfil')

@section('content')
    <main class="max-w-7xl mx-auto px-6 mt-10">
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
        <div class="grid md:grid-cols-3 gap-10">
            <!-- Posts section -->
            <section class="md:col-span-2 space-y-6">
                <div class="max-w-4xl mx-auto p-6">
                    <div class="flex items-center gap-6">
                        <img src="{{ !$user->cover_path ? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=009966&color=fff' : asset('storage/' . $user->cover_path)  }}" class="w-24 h-24 rounded-full object-cover" alt="avatar">
                        <div>
                            <h1 class="text-2xl font-bold">{{ $user->name }} 
                                @if ($loggedUserID == $user->id)
                                    <a href="{{ route("profile.edit", $user->username) }}" class="text-sm text-gray-500 hover:text-emerald-600"><i class="fas fa-pencil"></i> Editar Perfil</a>
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
                                <div class="text-sm text-gray-500"><i
                                        class="fas fa-book mr-1"></i> Posts <span class="font-semibold">{{ $user->posts_count }}</span></div>
                            </div>
                        </div>
                    </div>

                    @if (auth()->user())
                        <hr class="my-6">

                        @if ($loggedUserID == $user->id)
                            <div class="mt-4">
                                <a href="{{ route("post.create") }}" class="text-sm text-gray-500 hover:text-emerald-600 mr-3"><i
                                        class="fas fa-plus-circle mr-1"></i> Criar
                                    Novo
                                    Post</a>
                            </div>
                        @else
                            @livewire('follow-action', ['user' => $user])
                        @endif

                    @endif

                    <hr class="my-6">

                    <h2 class="text-xl font-semibold mb-4">Posts</h2>
                    @if ($posts->isEmpty())
                        <p class="text-gray-500">Nenhum post encontrado.</p>
                    @endif
                    @foreach ($posts as $post)
                        <article class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-lg transition mb-4">
                            <a href="{{ route("post.show", $post->slug) }}" class="text-lg font-semibold text-emerald-600 hover:underline"><i
                                    class="fas fa-book mr-1"></i> {{ $post->title }}</a>
                            <p class="text-gray-700 leading-relaxed mb-4 mt-2">{{ $post->description }}</p>
                            <p class="text-sm text-gray-600 mt-2">Publicado {{ $post->post_at->diffForHumans() }}</p>
                            @if ($loggedUserID == $user->id)
                                <div class="flex items-center mt-2 space-x-4">
                                    <a href="{{ route("post.edit", $post->id) }}" class="text-sm text-gray-500 hover:text-emerald-600 mr-2"><i
                                            class="fas fa-pencil"></i> Editar Post</a>
                                    <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-gray-500 hover:text-emerald-600"><i
                                                class="fas fa-trash-alt"></i> Excluir Post</button>
                                    </form>
                                </div>
                            @endif
                            <div class="flex items-center mt-2 gap-x-4">
                                <div class="text-sm text-gray-500"><i
                                        class="fas fa-book mr-1"></i> Status: <span class="font-semibold">{{ $post->status }}</span></div>
                                <div class="text-sm text-gray-500"><i class="fas fa-eye mr-1"></i>
                                    Visualizações <span class="font-semibold">{{ $post->views }}</span></div>
                                <div class="text-sm text-gray-500"><i
                                        class="fas fa-heart mr-1"></i> Likes <span class="font-semibold">{{ $post->likes_count }}</span></div>
                                <div class="text-sm text-gray-500"><i
                                        class="fas fa-comment mr-1"></i> Comentários <span class="font-semibold">{{ $post->comments_count }}</span></div>
                            </div>
                        </article>
                    @endforeach
                    <div>{{ $posts->links() }}</div>
                </div>

            </section>

            <!-- Sidebar -->
            <aside class="space-y-8">
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800"><i class="fas fa-user-friends mr-2"></i>Seguidores
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">Veja quem está seguindo {{ ($loggedUserID != $user->id ? $user->name : "você") }}.</p>
                    @livewire('follow-list', ['user' => $user])
                </div>
            </aside>
        </div>
    </main>
@endsection