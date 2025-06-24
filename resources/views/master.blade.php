<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <title>Viveiro Virtual</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen text-green-900 m-0 p-0 bg-center bg-cover flex items-center justify-center"
  style="background-image: url('{{ asset('Imagens/bg.jpg') }}');">



  @yield('content')
  </div>

  @yield('modal')

  @yield('scripts')

</body>

</html>