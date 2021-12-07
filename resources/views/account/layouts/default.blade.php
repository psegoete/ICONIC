<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    //<title>{{ config('app.name') }}</title>

    <!-- Favicon -->
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">

    <!-- Icons -->
    <link href="{{ asset('argon/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Argon CSS -->

    <link rel="stylesheet" href="{{ asset('assets/css/argon.mine209.css?v=1.0.0') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css">
    @yield('styles')

</head>

<body>
    <div id="app">

        <!-- Sidenav -->
        @include('account.layouts.partials.sidebar')
        <!-- Main content -->
        <div class="main-content" id="panel">
            //@include('layouts.partials._navigation')
            <!-- Topnav -->
                @include('account.layouts.partials.topnav')
            <!-- Header -->
            <div class="container">
                @include('layouts.partials.alerts._alerts')
            </div>
            <!-- Header -->
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"></li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-6 col-5 text-right">
                                <a href="#" class="btn btn-sm btn-neutral">New</a>
                                <a href="#" class="btn btn-sm btn-neutral">Filters</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
            <div class="container-fluid mt--6">
                {{-- <div class="row">
                    
                </div> --}}
                @yield('content')
            </div>

        </div>
    </div>
    <!-- end id=App
    Argon Scripts -->
    <!-- Core -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/lavalamp/js/jquery.lavalamp.min.js') }}"></script>
    <!-- Optional JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
    <!-- Argon JS -->
    <script src="{{ asset('assets/js/argon.mine209.js?v=1.0.0') }}"></script>
    <!-- Demo JS - remove this in your project -->
    {{-- <script src="{{ asset('assets/js/demo.min.js') }}"></script> --}}

    <!-- Scripts -->
    @yield('scripts')
        <!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/{{ env('TAWKTO_ID') }}/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
 </script>

 <script type="text/javascript">



    $(document).ready(function() {
 
 
 
     $('.summernote').summernote({
 
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
           
            ['view', ['fullscreen', 'codeview', 'help']],
          ],
 
      });

      $('.summernote1').summernote('code', $('#tooltip1').val());

 
   });
 
 
   $(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})
});


$('.click').on('change', function(){
    addrows();
});

function addrows(){
    $('.remove_tuning_options').remove();
    $.ajax({
        type: "GET",
        url: '/tuning_options/'+ $('#tuning_type').val(),
        data: {id: 2},
        success: function( msg ) { 

            $.each(msg.response, function( index, value ) {
                var value = '<div class="form-group col-md-4 remove_tuning_options">' +
                    '<div class="custom-control custom-checkbox">' +
                        '<input type="checkbox" name="tuning_options[]" class="custom-control-input" id="defaultUnchecked' +index+ '" value="'+value.id +'">' +
                        '<label class="custom-control-label" for="defaultUnchecked' + index +'">'+ value.label +'</label>' +
                    '</div>' +
                    
                '</div>';
                $('.addcheckbox').append(value);
              });
            $("#ajaxResponse").append("<div>"+msg+"</div>");
        }
    });

   
}

   
 </script>
    <!--End of Tawk.to Script-->
</body>

</html>