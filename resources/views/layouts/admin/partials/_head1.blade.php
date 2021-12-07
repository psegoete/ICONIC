<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">


<title>{{ $file_service->make.' '.$file_service->model.' '.$file_service->generation.' '.$file_service->engine }} | {{ companyName() }}</title>

<!-- Styles -->
<link href="{{ asset('css/admin.css') }}" rel="stylesheet">

<!-- Custom Styles -->
@yield('styles')