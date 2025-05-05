@extends("layouts.site")
@section('title', 'Editar Perfil')

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
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white"><i class="fas fa-user-edit mr-2"></i> Editar Perfil</h1>
        </div>
        <div class="grid md:grid-cols-3 gap-10">
            <!-- Posts section -->
            <section class="md:col-span-2 space-y-6">
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm dark:bg-neutral-950 dark:border-neutral-800">
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-800 px-4 py-3 rounded border border-red-300 mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700">Nome</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 mb-4 dark:bg-neutral-800">
                        </div>

                        <div>
                            <label for="username" class="block text-sm font-semibold text-gray-700">Usuário</label>
                            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 mb-4 dark:bg-neutral-800">
                        </div>

                        <div>
                            <label for="bio" class="block text-sm font-semibold text-gray-700">Bio</label>
                            <textarea name="bio" id="bio" rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 mb-4 dark:bg-neutral-800">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <div class="mb-12">
                            <label for="cover_path" class="block text-sm font-semibold text-gray-700 ">Imagem de perfil</label>
                            <input type="file" name="cover_path" id="cover_path"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 dark:bg-neutral-800">
                            <p class="text-gray-500 text-sm mt-1">Formato aceito: PNG, JPG, JPEG. Tamanho máximo: 2MB.</p>
                            <p class="text-gray-500 text-sm mt-1">Tamanho minimo recomendado 150x150</p>
                            <p class="text-gray-500 text-sm mt-1">Tamanho máximo recomendado 500x500</p>
                            <p class="text-gray-500 text-sm mt-1">Se você não deseja alterar a imagem, deixe este campo vazio.</p>

                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('profile.index', $user->username) }}"
                                class="text-gray-600 hover:text-emerald-600"><i class="fas fa-arrow-left"></i> Cancelar</a>
                            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
                                <i class="fas fa-save mr-1"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Sidebar -->
            <aside class="space-y-8 mb-8">
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm dark:bg-neutral-950 dark:border-neutral-800">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-white"><i class="fas fa-close mr-2"></i>Deletar Conta</h3>
                    <p class="text-gray-600 text-sm mb-4">Se você deseja excluir sua conta, clique no botão abaixo.</p>
                    <form action="{{ route('profile.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"><i
                                class="fas fa-trash-alt mr-1"></i> Deletar Conta</button>
                    </form>
                </div>

                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm dark:bg-neutral-950 dark:border-neutral-800">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-white"><i class="fas fa-image mr-2"></i>Remover Foto de Perfil</h3>
                    <p class="text-gray-600 text-sm mb-4 dark:text-gray-300">Se você deseja remover sua foto de perfil, clique no botão abaixo.</p>
                    @if ($user->cover_path)
                        <img src="{{ $user->cover_path ? asset('storage/' . $user->cover_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=009966&color=fff' }}"
                            alt="Avatar" class="w-full h-80 rounded mb-4 object-cover">
                        <form action="{{ route("profile.destroyImage", $user->id) }}" method="POST" class="inline mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"><i
                                    class="fas fa-trash-alt mr-1"></i> Remover Foto de Perfil</button>
                        </form>
                    @else
                        <p class="text-gray-500 text-sm mt-1">Você não possui uma foto de perfil.</p>
                    @endif
                </div>
            </aside>
        </div>
    </main>
@endsection