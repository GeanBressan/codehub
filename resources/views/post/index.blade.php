@extends('layouts.site')

@section('title', $post->title)

@section('content')
    <main class="max-w-7xl mx-auto px-6 mt-10">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded border border-green-300 mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded border border-red-300 mb-4">
                {{ session('error') }}
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="md:col-span-2 space-y-6 bg-white p-6 rounded-xl shadow-md mb-6 dark:bg-neutral-950 dark:border-neutral-800">
                @if ($post->cover_path)
                    <img src="{{ asset('storage/' . $post->cover_path) }}" alt="{{ $post->title }}" title="{{ $post->title }}"
                        class="rounded-xl mb-4 max-h-96 object-cover w-full">
                @endif
                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ !$post->user->cover_path ? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&background=009966&color=fff' : asset('storage/' . $post->user->cover_path)  }}"
                        class="w-10 h-10 rounded-full object-cover" alt="avatar">
                    <div>
                        <a href="{{ route("profile.show", $post->user->username) }}"
                            class="text-sm font-semibold hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-600">{{ $post->user->name }}</a>
                        <p class="text-xs text-gray-400">Em: <a href="{{ route("category.show", $post->category->slug) }}"
                                class="hover:text-emerald-600 cursor-pointer">{{ $post->category->name }}</a> -
                            {{ $post->post_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-emerald-600 mb-4">{{ $post->title }}</h2>
                <p class="text-gray-700 mb-4 dark:text-white">{!! $post->content !!}</p>

                <div class="flex flex-wrap gap-2 mt-4">
                    @forelse($post->tags as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}"
                            class="bg-emerald-600 text-white px-2 py-1 rounded-full text-[12px] hover:bg-emerald-700 transition">{{ $tag->name }}</a>
                    @empty
                        <a href="#" class="bg-gray-300 text-gray-500 px-2 py-1 rounded-full text-[12px]">Nenhuma TAG
                            encontrada.</a>
                    @endforelse
                </div>
                <div class="flex items-center gap-4 mt-6">
                    <div class="text-sm text-gray-500 hover:text-emerald-600"><i class="fas fa-eye mr-1"></i> <span
                            class="font-semibold">{{ $post->views }}</span></div>
                    @livewire('like-post', ['postId' => $post->id])
                    @livewire('save-post', ['postId' => $post->id])
                </div>
                <p class="mt-8 text-emerald-600 hover:underline"><a href="{{ route("home") }}">Voltar à Home</a></p>

                <!-- Comments section -->
                <div class="bg-gray-100 p-6 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    @livewire('comments', ['postId' => $post->id])
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-8">
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm dark:bg-neutral-950 dark:border-neutral-800">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white"><i class="fas fa-book mr-2"></i>Posts
                        Recomendados</h3>
                    <p class="text-gray-600 text-sm mb-4 dark:text-gray-300">Baseado nos seus interesses.</p>
                    <ul class="space-y-4">
                        @foreach ($recommendedPosts as $recommendedPost)
                            <li class="bg-gray-100 border border-gray-200 p-4 rounded-lg dark:bg-neutral-800 dark:border-neutral-700">
                                <a href="{{ route("post.show", $recommendedPost->slug) }}"
                                    class="text-sm text-emerald-600 hover:underline">{{ $recommendedPost->title }}</a>
                                <p class="text-gray-500 text-xs mt-1">Por {{ $recommendedPost->user->name }} -
                                    {{ $recommendedPost->post_at->diffForHumans() }}
                                </p>
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
            </aside>
        </div>
    </main>
@endsection