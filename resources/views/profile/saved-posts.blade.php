@extends('layouts.site')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
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
            <!-- Posts section -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($posts as $post)
                    <article class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-lg transition dark:bg-neutral-950 dark:border-neutral-800">
                        @if ($post->cover_path)
                            <img src="{{ asset('storage/' . $post->cover_path) }}" alt="{{ $post->title }}"
                                title="{{ $post->title }}" class="rounded-xl mb-4 max-h-96 h-60 object-cover w-full">
                        @endif
                        <div class="flex items-center gap-4 mb-4">
                            <img src="{{ !$post->user->cover_path ? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&background=009966&color=fff' : asset('storage/' . $post->user->cover_path)  }}" class="w-10 h-10 rounded-full object-cover" alt="avatar">
                            <div>
                                <a href="{{ route("profile.show", $post->user->username) }}" class="text-sm font-semibold hover:text-emerald-600">{{ $post->user->name }}</a>
                                <p class="text-xs text-gray-400">Em: <a href="{{ route("category.show", $post->category->slug) }}" class="hover:text-emerald-600 cursor-pointer">{{ $post->category->name }}</a> - {{ $post->post_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <a href="{{ route("post.show", $post->slug) }}" class="text-1xl font-semibold text-gray-900 hover:text-emerald-600 cursor-pointer dark:text-white dark:hover:text-emerald-600">{{ $post->title }}</a>
                        <div class="flex flex-wrap gap-2 mt-2 mb-4">
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
                                <span class="font-semibold">{{ $post->likes_count }}</span></div>
                        </div>
                    </article>
                @empty
                    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm text-center">
                        <p class="text-gray-700">Nenhum post encontrado.</p>
                    </div>
                @endforelse

            </section>
            <div class="mt-6">{{ $posts->links() }}</div>
    </main>
@endsection