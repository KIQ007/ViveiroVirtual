@extends('master')

@section('content')

    <div class="max-w-4xl mx-auto mt-10 p-8 bg-white/30 border border-gray-300/30 rounded-xl shadow-lg backdrop-blur-md">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-green-900 mb-4">🌿 Bem-vindo ao Viveiro Virtual!</h1>
            <p class="text-lg text-green-800 mb-6">Aqui você pode cadastrar, visualizar e gerenciar suas plantas com
                facilidade.</p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('plantas.index') }}"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    🌱 Ver Plantas
                </a>
                <a href="{{ route('plantas.create') }}"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    ➕ Cadastrar Nova
                </a>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6 text-green-900">
            <div class="bg-white/50 rounded-lg p-4 shadow-md">
                <h2 class="text-xl font-semibold mb-2">🌼 Cadastro Simples</h2>
                <p>Adicione novas plantas com nome, espécie, descrição e imagem.</p>
            </div>
            <div class="bg-white/50 rounded-lg p-4 shadow-md">
                <h2 class="text-xl font-semibold mb-2">🔄 Atualizações</h2>
                <p>Edite ou remova plantas quando quiser, mantendo seu viveiro sempre atualizado.</p>
            </div>
        </div>
    </div>

@endsection