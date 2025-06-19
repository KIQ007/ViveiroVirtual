@extends('master')

@section('content')
<div class="min-h-screen text-green-900 m-0 p-0 bg-center bg-cover flex items-center justify-center"
     style="background-image: url('{{ asset('Imagens/bg.png') }}')">

  <div class="max-w-4xl w-full mx-4 my-4 p-6 bg-white/30 border-2 border-gray-300/30 rounded-xl shadow-md backdrop-blur-xl flex gap-6">

    <!-- Foto da planta -->
    <div class="flex-shrink-0">
      <img src="{{ $planta->foto ? asset('storage/' . $planta->foto) : asset('Imagens/bg.png') }}"
           alt="Foto da planta {{ $planta->nome }}"
           class="w-48 h-48 rounded border border-green-700 object-cover" />
    </div>

    <!-- Detalhes da planta -->
    <div class="flex flex-col flex-grow gap-4">
      <h1 class="text-3xl font-bold text-center mb-4">{{ $planta->nome }}</h1>

      <div>
        <p class="text-green-800 font-semibold mb-1">Nome científico:</p>
        <p class="text-green-900 text-lg">{{ $planta->nome_cientifico ?? '-' }}</p>
      </div>

      <div>
        <p class="text-green-800 font-semibold mb-1">Descrição:</p>
        <p class="text-green-900 text-lg whitespace-pre-wrap max-h-48 overflow-auto">{{ $planta->descricao ?? '-' }}</p>
      </div>

      <div class="flex gap-4 mt-4">
        <a href="{{ route('plantas.edit', ['planta' => $planta->id]) }}"
           class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition text-center flex items-center gap-1">
          Editar
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5h2m2 2v10a2 2 0 01-2 2H9a2 2 0 01-2-2V7h2m2-2v4h4" />
          </svg>
        </a>

        <form id="formExcluir" action="{{ route('plantas.destroy', ['planta' => $planta->id]) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" id="btnExcluir" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
            Excluir
          </button>
        </form>
      </div>

      <button id="btnVoltar" class="self-start bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition mt-6">
        ← Voltar
      </button>
    </div>
  </div>

  <script>
    document.getElementById('btnVoltar').addEventListener('click', () => {
      window.history.back();
    });

    // AJAX para excluir planta
    document.getElementById('formExcluir').addEventListener('submit', async function(event) {
      event.preventDefault();

      if (!confirm('Tem certeza que deseja excluir esta planta?')) {
        return;
      }

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
          window.location.href = "{{ route('plantas.index') }}"; // Redireciona para a lista
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
