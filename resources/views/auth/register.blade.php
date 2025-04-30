@extends('layouts.auth')

@section('title', 'Registro')

@section('content')
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-emerald-600">Criar Conta no CodeHub</h1>
        <form class="space-y-4" method="post" action="{{ route('register') }}">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" name="name"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-emerald-200">
            </div>
            @error('name')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror

            <div>
                <label class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" name="email"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-emerald-200">
            </div>
            @error('email')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror

            <div>
                <label class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-emerald-200">
            </div>
            @error('password')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror

            <div>
                <label class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
                <input type="password" name="password_confirmation"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-emerald-200">
            </div>
            @error('password')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror

            <button type="submit"
                class="w-full bg-emerald-600 text-white py-2 rounded-lg hover:bg-emerald-700 transition">Cadastrar</button>
        </form>
        <p class="text-sm text-center text-gray-500 mt-4">
            Já tem uma conta? <a href="{{ route("login.form") }}" class="text-emerald-600 hover:underline">Entrar</a>
        </p>
    </div>
@endsection