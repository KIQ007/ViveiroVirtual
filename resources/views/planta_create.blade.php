@extends('master')

@section('content')
  <div
    class="max-w-lg w-full mx-4 my-4 p-6 bg-white/30 border-2 border-gray-300/30 rounded-xl shadow-md backdrop-blur-xl">

    <!-- Cabeçalho com botão voltar e título -->
    <div class="mb-6 relative">
    <a href="{{ url()->previous() }}"
      class="absolute left-0 top-1/2 -translate-y-1/2 flex items-center text-green-800 hover:text-green-600 font-medium text-sm">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      Voltar
    </a>
    <h1 class="text-2xl font-bold text-green-900 text-center">🌿 Adicionar Planta</h1>
    </div>

    @if(session('message'))
    <p class="mb-4 text-green-700 font-semibold">{{ session('message') }}</p>
    @endif

    <form action="{{ route('plantas.store') }}" method="POST" enctype="multipart/form-data" id="formPlanta"
    class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-medium text-green-800 mb-1">Nome da Planta</label>
      <input type="text" name="nome" required
      class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
      placeholder="Ex: Manjericão, Sálvia, Hortelã" value="{{ old('nome') }}">
    </div>

    <div>
      <label class="block text-sm font-medium text-green-800 mb-1">Espécie</label>
      <input type="text" name="nome_cientifico"
      class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
      placeholder="Ex: Ocimum basilicum (opcional)" value="{{ old('nome_cientifico') }}">
    </div>

    <div>
      <label class="block text-sm font-medium text-green-800 mb-1">Observações</label>
      <textarea name="descricao" rows="3"
      class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
      placeholder="Alguma informação adicional sobre a planta...">{{ old('descricao') }}</textarea>
    </div>

    <div class="border-t border-green-200 my-4"></div>

    <div>
      <h2 class="text-lg font-medium text-green-800 mb-3">Foto da Planta</h2>
      <div
      class="border-2 border-dashed border-green-300 rounded-lg p-4 text-center transition hover:border-green-400 bg-white text-green-800">

      <div id="uploadArea" class="cursor-pointer">
        <svg class="mx-auto h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <div class="mt-2 flex justify-center text-sm text-green-800">
        <label class="relative cursor-pointer rounded-md font-medium">
          <span>Carregar uma imagem</span>
          <input id="fileUpload" type="file" name="foto" class="sr-only" accept="image/*">
        </label>
        <p class="pl-1">ou arraste e solte</p>
        </div>
        <p class="text-xs text-green-700 mt-1">PNG, JPG, GIF até 5MB</p>
      </div>

      <div id="previewContainer" class="hidden mt-3">
        <img id="imagePreview" src="#" alt="Pré-visualização"
        class="mx-auto max-h-40 rounded-md border border-green-200">
        <button type="button" onclick="removeImage()" class="mt-2 text-sm text-red-600 hover:text-red-800">Remover
        imagem</button>
      </div>

      </div>
    </div>

    <div class="pt-2">
      <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition">
      Cadastrar Planta
      </button>
    </div>
    </form>
  </div>

  <script>
    const fileUpload = document.getElementById('fileUpload');
    const uploadArea = document.getElementById('uploadArea');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');

    // Preview da imagem
    fileUpload.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (event) {
      imagePreview.src = event.target.result;
      uploadArea.classList.add('hidden');
      previewContainer.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    }
    });

    // Remover imagem
    function removeImage() {
    fileUpload.value = '';
    imagePreview.src = '#';
    previewContainer.classList.add('hidden');
    uploadArea.classList.remove('hidden');
    }

    // Drag & Drop
    uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    e.stopPropagation();
    uploadArea.classList.add('border-green-500', 'bg-green-50');
    });

    uploadArea.addEventListener('dragleave', (e) => {
    e.preventDefault();
    e.stopPropagation();
    uploadArea.classList.remove('border-green-500', 'bg-green-50');
    });

    uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    e.stopPropagation();
    uploadArea.classList.remove('border-green-500', 'bg-green-50');

    const file = e.dataTransfer.files[0];
    if (file && file.type.match('image.*')) {
      fileUpload.files = e.dataTransfer.files;
      fileUpload.dispatchEvent(new Event('change'));
    }
    });

    // Envio AJAX do formulário
    document.getElementById('formPlanta').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const url = form.action;

    try {
      const response = await fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        'Accept': 'application/json'
      },
      body: formData
      });

      if (response.ok) {
      alert('Planta cadastrada com sucesso!');
      window.location.href = "{{ route('plantas.index') }}";
      } else {
      const data = await response.json();
      alert('Erro ao cadastrar: ' + (data.message || 'Verifique os campos.'));
      }
    } catch (error) {
      alert('Erro na requisição: ' + error.message);
    }
    });
  </script>

  </div>
@endsection