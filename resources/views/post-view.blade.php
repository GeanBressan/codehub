@extends('layouts.site')

@section('title', $post->title)

@section('content')
    <main class="max-w-7xl mx-auto px-6 mt-10">
        <div class="grid md:grid-cols-3 gap-10">
        <div class="md:col-span-2 space-y-6 bg-white p-6 rounded-xl shadow-md mb-6">
            @if ($post->cover_path)
                <img src="{{ asset('storage/' . $post->cover_path) }}" alt="{{ $post->title }}" title="{{ $post->title }}"
                    class="rounded-xl mb-4 max-h-96 object-cover w-full">
            @endif
            <div class="flex items-center gap-4 mb-4">
                <img src="{{ $post->user->cover_path ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&background=0D8ABC&color=fff'  }}"
                    class="w-10 h-10 rounded-full" alt="avatar">
                <div>
                    <p class="text-sm font-semibold">{{ $post->user->name }}</p>
                    <p class="text-xs text-gray-400">Em: <a href="{{ route("category.show", $post->category->slug) }}"
                        class="hover:text-emerald-600 cursor-pointer">{{ $post->category->name }}</a> - {{ $post->post_at->diffForHumans() }}</p>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-emerald-600 mb-4">{{ $post->title }}</h2>
            <p class="text-gray-700 mb-4">{!! $post->content !!}</p>

            <div class="flex flex-wrap gap-2 mt-4">
                @forelse($post->tags as $tag)
                    <a href="{{ route('tag.show', $tag->slug) }}"
                        class="bg-emerald-600 text-white px-2 py-1 rounded-full text-[12px] hover:bg-emerald-700 transition">{{ $tag->name }}</a>
                @empty
                    <a href="#" class="bg-gray-300 text-gray-500 px-2 py-1 rounded-full text-[12px]">Nenhuma TAG encontrada.</a>
                @endforelse
            </div>
            <p class="mt-8 text-emerald-600 hover:underline"><a href="{{ route("home") }}">Voltar à Home</a></p>
        </div>

        <!-- Sidebar -->
        <aside class="space-y-8">
            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm">
                <h3 class="text-lg font-semibold mb-3 text-gray-800"><i class="fas fa-folder-open mr-2"></i>Categorias</h3>
                <p class="text-gray-600 text-sm mb-4">Explore posts por categorias.</p>
                <ul class="space-y-2">
                    @forelse($categories as $category)
                        <li><a href="{{ route("category.show", $category->slug) }}" class="text-emerald-600 hover:underline">{{ $category->name }}</a></li>
                    @empty
                        <li><a href="#" class="text-gray-500">Nenhuma categoria encontrada.</a></li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm">
                <h3 class="text-lg font-semibold mb-3 text-gray-800"><i class="fas fa-hashtag mr-2"></i>Tags</h3>

                <p class="text-gray-600 text-sm mb-4">As tags ajudam a encontrar posts relacionados.</p>
                <div class="flex flex-wrap gap-2">
                    @forelse($tags as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}"
                            class="bg-emerald-600 text-white px-3 py-1 rounded-full text-sm hover:bg-emerald-700 transition">{{ $tag->name }}</a>
                    @empty
                        <a href="#" class="bg-gray-300 text-gray-500 px-3 py-1 rounded-full text-sm">Nenhuma TAG encontrada.</a>
                    @endforelse
                </div>
            </div>

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm">
                <h3 class="text-lg font-semibold mb-3 text-gray-800"><i class="fas fa-envelope-open-text mr-2"></i>Newsletter
                </h3>
                <p class="text-gray-600 text-sm mb-4">Receba os melhores posts direto na sua caixa de entrada.</p>
                <form class="flex flex-col gap-3">
                    <input type="email" placeholder="Seu e-mail"
                        class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    <button
                        class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">Inscrever-se</button>
                </form>
            </div>
        </aside>
        </div>
    </main>
@endsection