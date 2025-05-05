@extends('layouts.site')

@section('title', "Criar Postagem")

@section('content')
    <main class="max-w-7xl mx-auto px-6 mt-10">
        <div class="grid md:grid-cols-3 gap-10">
            <div class="md:col-span-2 space-y-6 bg-white p-6 rounded-xl shadow-md mb-6 dark:bg-neutral-950 dark:border-neutral-800">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 dark:text-white">Criar Nova Postagem</h2>
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
                @if ($errors->any())
                    <div class="bg-red-100 text-red-800 px-4 py-3 rounded border border-red-300 mb-2">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 p-2 dark:bg-neutral-800"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                        <input type="text" name="description" id="description" value="{{ old('description') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 p-2 dark:bg-neutral-800"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Conteúdo</label>
                        <textarea name="content" id="content" rows="10"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 dark:bg-neutral-800"
                            >{{ old('content') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="cover_path" class="block text-sm font-medium text-gray-700">Imagem de Capa</label>
                        <input type="file" name="cover_path" id="cover_path"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 p-2 dark:bg-neutral-800">
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Categoria</label>
                        <select name="category_id" id="category_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 p-2 dark:bg-neutral-800"
                            required>
                            <option value="">Selecione uma categoria</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                        <select id="tags" name="tags[]" multiple
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 p-2 dark:bg-neutral-800"
                            required>
                            <option value="">Selecione uma categoria</option>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 p-2 dark:bg-neutral-800"
                            required>
                            <option value="draft">Rascunho</option>
                            <option value="published">Publicado</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <button type="submit"
                            class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">Postar</button>
                        <button type="reset"
                            class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">Limpar</button>
                    </div>
                </form>
            </div>
            <aside class="space-y-8 mb-8">
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm dark:bg-neutral-950 dark:border-neutral-800">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white"><i class="fas fa-book mr-2"></i>Escrevendo bons
                        posts</h3>
                    <p class="text-gray-600 text-sm mb-4  dark:text-gray-300">Dicas para criar postagens envolventes e informativas.</p>
                    <ul class="space-y-2">
                        <li class="text-sm text-gray-500">1. Use títulos claros e descritivos.</li>
                        <li class="text-sm text-gray-500">2. Estruture seu conteúdo com subtítulos.</li>
                        <li class="text-sm text-gray-500">3. Use imagens relevantes para ilustrar seus pontos.</li>
                        <li class="text-sm text-gray-500">4. Revise seu texto para evitar erros gramaticais.</li>
                        <li class="text-sm text-gray-500">5. Encoraje a interação com perguntas ou chamadas à ação.</li>
                        <li class="text-sm text-gray-500">6. Use links para direcionar os leitores a mais informações.</li>
                        <li class="text-sm text-gray-500">7. Mantenha um tom amigável e acessível.</li>
                        <li class="text-sm text-gray-500">8. Considere o público-alvo e adapte seu conteúdo a ele.</li>
                        <li class="text-sm text-gray-500">9. Use listas e parágrafos curtos para facilitar a leitura.</li>
                        <li class="text-sm text-gray-500">10. Compartilhe suas experiências pessoais para tornar o conteúdo
                            mais autêntico.</li>
                    </ul>
                </div>
            </aside>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#content',
            plugins: 'lists link image code',
            toolbar: 'undo redo | blocks | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code',
            menubar: false,
            height: 300,
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });

        new TomSelect("#category_id", {
            create: false, // permite criar novas opções
            persist: false
        });

        new TomSelect("#tags", {
            plugins: ['remove_button'],
            create: true, // permite criar novas opções
            persist: false
        });
    </script>
@endsection