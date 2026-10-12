<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <link rel="shortcut icon" href="{{ $favicon_url }}" /> --}}
{{-- <link rel="apple-touch-icon" href="{{ url('/img/apple-touch-icon.png') }}" /> --}}
<link rel="canonical" href="{{ url()->current() }}">
<meta name="theme-color" content="#000000" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<style>[x-cloak] { display: none !important; }</style>

@vite(['resources/css/app.css'])
@stack('vite')
</head>

<body class="min-h-screen bg-slate-50">
  <div class="flex min-h-screen flex-col">
    <div class="flex-1 flex items-center justify-center px-4">

      @yield('content')
    </div>

    <footer class="py-6 text-center text-xs text-slate-500">
      © {{ date('Y') }} Stodio
    </footer>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<x-core::ui.toast />

@stack('scripts')
</body>

</html>