@extends('master')

@section('content')

<div class="max-w-4xl w-full mx-4 my-4 p-6 bg-white/30 border-2 border-gray-300/30 rounded-xl shadow-md backdrop-blur-xl">
  <h1 class="text-3xl font-bold text-center mb-4">🌱 Viveiro Virtual</h1>
  <p class="text-center text-green-900 font-medium mb-6">Gerencie suas plantas com facilidade</p>

  <div class="flex justify-center mb-6">
    <a href="{{ route('plantas.create') }}" 
       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center gap-1">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
      </svg>
      Nova Planta
    </a>
  </div>

  <div id="plantasContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <!-- Plantas serão carregadas aqui -->
  </div>
</div>

@endsection

@section('scripts')
<script>
  async function carregarPlantas() {
    try {
      const response = await fetch("{{ route('plantas.json') }}");
      if (!response.ok) throw new Error('Erro ao carregar plantas');

      const plantas = await response.json();
      const container = document.getElementById('plantasContainer');
      container.innerHTML = '';

      plantas.forEach(planta => {
        const div = document.createElement('div');
        div.className = "bg-white/80 rounded-md p-3 shadow flex flex-col";

        div.innerHTML = `
          <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 flex-grow">
              <img src="${planta.foto ? '/storage/' + planta.foto : 'Imagens/bg.png'}" 
                   alt="${planta.nome}" 
                   class="w-12 h-12 rounded object-cover border border-green-700 cursor-pointer"
                   onclick="window.location='{{ url('plantas') }}/${planta.id}'">
              <span class="text-green-800 font-semibold">${planta.nome}</span>
            </div>
            <div>
              <a href="{{ url('plantas') }}/${planta.id}/edit" 
                 class="bg-yellow-500 text-white p-2 rounded hover:bg-yellow-600 transition flex items-center justify-center"
                 title="Editar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
              </a>
            </div>
          </div>
        `;

        container.appendChild(div);
      });
    } catch (error) {
      console.error(error);
      alert('Falha ao carregar as plantas.');
    }
  }

  document.addEventListener('DOMContentLoaded', carregarPlantas);
</script>
@endsection
