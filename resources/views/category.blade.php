@extends('layouts.site')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-6 mt-10">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Posts em: {{ $category->name }}</h1>
            <a href="{{ route('home') }}" class="text-emerald-600 hover:underline">Voltar à Home</a>
        </div>
        <div class="grid md:grid-cols-3 gap-10">
            <!-- Posts section -->
            <section class="md:col-span-2 space-y-6">
                <!-- Post card -->

                @forelse($posts as $post)
                    <article class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-lg transition dark:bg-neutral-950 dark:border-neutral-800">
                        @if ($post->cover_path)
                            <img src="{{ asset('storage/' . $post->cover_path) }}" alt="{{ $post->title }}"
                                title="{{ $post->title }}" class="rounded-xl mb-4 max-h-96 object-cover w-full">
                        @endif
                        <div class="flex items-center gap-4 mb-4">
                            <img src="{{ !$post->user->cover_path ? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&background=009966&color=fff' : asset('storage/' . $post->user->cover_path)  }}" class="w-10 h-10 rounded-full object-cover" alt="avatar">
                            <div>
                                <a href="{{ route("profile.show", $post->user->username) }}" class="text-sm font-semibold hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-600">{{ $post->user->name }}</a>
                                <p class="text-xs text-gray-400">Em: <a href="{{ route("category.show", $post->category->slug) }}" class="hover:text-emerald-600 cursor-pointer">{{ $post->category->name }}</a> - {{ $post->post_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <a href="{{ route("post.show", $post->slug) }}" class="text-2xl font-semibold text-gray-900 hover:text-emerald-600 cursor-pointer dark:text-white dark:hover:text-emerald-600">{{ $post->title }}</a>
                        <p class="text-gray-700 leading-relaxed mb-4 mt-4 dark:text-white">{{ $post->description }}</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @forelse($post->tags as $tag)
                                <a href="{{ route('tag.show', $tag->slug) }}"
                                    class="bg-emerald-600 text-white px-2 py-1 rounded-full text-[12px] hover:bg-emerald-700 transition">{{ $tag->name }}</a>
                            @empty
                                <a href="#" class="bg-gray-300 text-gray-500 px-2 py-1 rounded-full text-[12px]">Nenhuma TAG encontrada.</a>
                            @endforelse
                        </div>
                        <div class="flex items-center gap-4 mt-2">
                            <div class="text-sm text-gray-500 hover:text-emerald-600"><i class="fas fa-eye mr-1"></i> <span
                                    class="font-semibold">{{ $post->views }}</span></div>
                            <div class="text-sm text-gray-500 hover:text-emerald-600"><i class="fas fa-heart mr-1"></i>
                                <span class="font-semibold">{{ $post->likedByUsers->count() }}</span></div>
                        </div>
                    </article>
                @empty
                    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm text-center dark:bg-neutral-950 dark:border-neutral-800 dark:text-white">
                        <p class="text-gray-700">Nenhum post encontrado.</p>
                    </div>
                @endforelse

                <div>{{ $posts->links() }}</div>
            </section>

            <!-- Sidebar -->
            <aside class="space-y-8 mb-8">
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm dark:bg-neutral-950 dark:border-neutral-800">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white"><i class="fas fa-user-friends mr-2"></i>Autores
                        Populares</h3>
                    <p class="text-gray-600 text-sm mb-4 dark:text-gray-300">Conheça os autores mais populares.</p>
                    <ul class="space-y-4">
                        @foreach ($popularAuthors as $author)
                            <li class="flex items-center gap-4">
                                <img src="{{ !$author->cover_path ? 'https://ui-avatars.com/api/?name=' . urlencode($author->name) . '&background=009966&color=fff' : asset('storage/' . $author->cover_path)  }}" class="w-10 h-10 rounded-full object-cover" alt="avatar">
                                <div>
                                    <a href="{{ route("profile.show", $author->username) }}"
                                        class="text-sm font-semibold hover:text-emerald-600 dark:text-gray-300 dark:hover:text-emerald-600">{{ $author->name }}</a>
                                    <p class="text-xs text-gray-400">Seguidores: {{ $author->followers_count }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm dark:bg-neutral-950 dark:border-neutral-800">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white"><i class="fas fa-heart mr-2"></i>Posts
                        Populares</h3>
                    <p class="text-gray-600 text-sm mb-4 dark:text-gray-300">Os posts mais curtidos.</p>
                    <ul class="space-y-4">
                        @foreach ($popularPosts as $popularPost)
                            <li class="bg-gray-100 border border-gray-200 p-4 rounded-lg dark:bg-neutral-800 dark:border-neutral-700">
                                <a href="{{ route("post.show", $popularPost->slug) }}"
                                    class="text-sm text-emerald-600 hover:underline">{{ $popularPost->title }}</a>
                                <p class="text-gray-500 text-xs mt-1">Por {{ $popularPost->user->name }} -
                                    {{ $popularPost->post_at->diffForHumans() }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm dark:bg-neutral-950 dark:border-neutral-800">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-white"><i
                            class="fas fa-folder-open mr-2"></i>Categorias</h3>
                    <p class="text-gray-600 text-sm mb-4 dark:text-gray-300">Explore posts por categorias.</p>
                    <ul class="space-y-2">
                        @forelse($categories as $category)
                            <li><a href="{{ route("category.show", $category->slug) }}" class="text-emerald-600 hover:underline">{{ $category->name }}</a></li>
                        @empty
                            <li><a href="#" class="text-gray-500 dark:text-gray-300">Nenhuma categoria encontrada.</a></li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm dark:bg-neutral-950 dark:border-neutral-800">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-white"><i class="fas fa-hashtag mr-2"></i>Tags</h3>

                    <p class="text-gray-600 text-sm mb-4 dark:text-gray-300">As tags ajudam a encontrar posts relacionados.</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse($tags as $tag)
                            <a href="{{ route('tag.show', $tag->slug) }}" class="bg-emerald-600 text-white px-3 py-1 rounded-full text-sm hover:bg-emerald-700 transition">{{ $tag->name }}</a>
                        @empty
                            <a href="#" class="text-gray-500 px-3 py-1 rounded-full text-sm dark:text-gray-300">Nenhuma TAG encontrada.</a>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </main>
@endsection