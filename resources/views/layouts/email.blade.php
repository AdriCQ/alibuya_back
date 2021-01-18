<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Vendors -->
  <!-- Bootstrap -->
  <link href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
  <!-- Fonts -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet"> -->

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  @section('extra_styles')
  @show
</head>

<body class="font-sans antialiased">
  <header id="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">
        <img src="{{ asset('images/logos/logo_text.png') }}" width="75" height="30" class="d-inline-block align-top" alt="">
      </a>
    </nav>
  </header>
  <main id="app">
    <div class="container">
      @section('content')
      This is the master sidebar.
      @show
    </div>

  </main>

  <footer class="text-center">
    <div>
      <a href="https://alibuya.net" target="_blank">Alibuya</a>
      <p> Derechos Reservados &copy;</p>
    </div>
  </footer>

  <!-- Vendors -->
  <!-- Vuejs -->
  <script src="{{ asset('vendors/vue/vue.min.js') }}"></script>
  <!-- JQuery -->
  <script src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

   @section('extra_scripts')
  @show
</body>

</html>