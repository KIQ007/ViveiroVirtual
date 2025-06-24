@extends('master')

@section('content')
  <div
    class="max-w-4xl w-full mx-4 my-4 p-6 bg-white/30 border-2 border-gray-300/30 rounded-xl shadow-md backdrop-blur-xl">

    <!-- Botão Voltar -->
    <div class="mb-4">
    <a href="{{ route('plantas.index') }}"
      class="inline-flex items-center text-green-800 hover:text-green-600 font-medium text-sm">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      Voltar para a lista
    </a>
    </div>

    <div class="flex gap-6 flex-col sm:flex-row">

    <!-- Foto da planta -->
    <div class="flex-shrink-0 self-center sm:self-start">
      <img src="{{ $planta->foto ? asset('storage/' . $planta->foto) : asset('Imagens/bg.png') }}"
      alt="Foto da planta {{ $planta->nome }}" class="w-48 h-48 rounded border border-green-700 object-cover" />
    </div>

    <!-- Detalhes -->
    <div class="flex flex-col flex-grow gap-4">

      <h1 class="text-3xl font-bold text-center sm:text-left mb-2">{{ $planta->nome }}</h1>

      <div>
      <p class="text-green-800 font-semibold mb-1">Nome científico:</p>
      <p class="text-green-900 text-lg">{{ $planta->nome_cientifico ?? '-' }}</p>
      </div>

      <div>
      <p class="text-green-800 font-semibold mb-1">Descrição:</p>
      <p class="text-green-900 text-lg whitespace-pre-wrap max-h-48 overflow-auto">{{ $planta->descricao ?? '-' }}</p>
      </div>

      <!-- Botões de ação -->
      <div class="flex flex-wrap gap-3 mt-4 justify-start">
      <a href="{{ route('plantas.edit', ['planta' => $planta->id]) }}"
        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition flex items-center gap-1">
        Editar
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M11 5h2m2 2v10a2 2 0 01-2 2H9a2 2 0 01-2-2V7h2m2-2v4h4" />
        </svg>
      </a>

      <form id="formExcluir" action="{{ route('plantas.destroy', ['planta' => $planta->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" id="btnExcluir"
        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition flex items-center gap-1">
        Excluir
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
          viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
        </button>
      </form>
      </div>


      <script>
      // AJAX para excluir planta
      document.getElementById('formExcluir').addEventListener('submit', async function (event) {
        event.preventDefault();

        if (!confirm('Tem certeza que deseja excluir esta planta?')) return;

        const url = this.action;
        const token = this.querySelector('input[name="_token"]').value;

        try {
        const response = await fetch(url, {
          method: 'DELETE',
          headers: {
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          },
        });

        if (response.ok) {
          alert('Planta excluída com sucesso!');
          window.location.href = "{{ route('plantas.index') }}";
        } else {
          const data = await response.json();
          alert('Erro ao excluir a planta: ' + (data.message || 'Erro desconhecido'));
        }
        } catch (error) {
        alert('Erro na requisição: ' + error.message);
        }
      });
      </script>
    </div>
@endsection