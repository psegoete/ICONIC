<!-- Scripts -->
<!-- Included in admin js
     jQuery
     bootstrap
     VueJs
     + Core UI js
 -->
<script src="{{ asset('js/admin.js') }}"></script>

<!-- Include modules below in 'admin.js'
        Pace Progress
        Chart Js
 -->

<!-- Text Editor -->
{{--  <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>  --}}

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> 
{{--  <script src="{{ asset('js/admin.js') }}"></script>  --}}
<link href="{{ asset('css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('css/responsive.dataTables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<link href="{{ asset('css/jquery-confirm.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery-confirm.min.js') }}"></script>

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
    
    $('.click').on('change', function(){
        addrows();
    });

    $('.changeToInput').on('click', function(){
        $('.changeInputs').empty();
        var value = '<div class="form-group{{ $errors->has('make') ? ' has-error' : '' }} col-md-2">' +
            '<label for="make" class="control-label">Make</label>' +
            '<input id="make" type="text" class="form-control{{ $errors->has('make') ? ' is-invalid' : '' }} " name="make"  required="required" placeholder="Enter make" value="{{ old('make') }}">' +

            '@if ($errors->has('make'))' +
                '<div class="invalid-feedback">' +
                    '<strong>{{ $errors->first('make') }}</strong>' +
                    '</div>' +
                    '@endif' +
                    '</div>' +



                    '<div class="form-group{{ $errors->has('model') ? ' has-error' : '' }} col-md-2">' +
                        '<label for="model" class="control-label">Model</label>' +
                        '<input id="model" type="text" class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }} " name="model"  required="required" placeholder="Enter model" value="{{ old('model') }}">' +

                        '@if ($errors->has('model'))' +
                        '<div class="invalid-feedback">' +
                            '<strong>{{ $errors->first('model') }}</strong>' +
                            '</div>' +
                            '@endif' +
                            '</div>' +

                            '<div class="form-group{{ $errors->has('generation') ? ' has-error' : '' }} col-md-2">' +
                                '<label for="generation" class="control-label">Generation</label>' +
                                '<input id="generation" type="text" class="form-control{{ $errors->has('generation') ? ' is-invalid' : '' }} "  required="required" placeholder="Enter generation" name="generation" value="{{ old('generation') }}">' +

                                '@if ($errors->has('generation'))' +
                                '<div class="invalid-feedback">' +
                    '<strong>{{ $errors->first('generation') }}</strong>' +
                    '</div>' +
                    '@endif' +
                    '</div>' +

        
                    '<div class="form-group{{ $errors->has('engine') ? ' has-error' : '' }} col-md-2">' +
                        '<label for="engine" class="control-label">Engine</label>' +
                        '<input id="engine" type="text" class="form-control{{ $errors->has('engine') ? ' is-invalid' : '' }} " name="engine"  placeholder="Enter engine" required="required" value="{{ old('engine') }}">' +

                        '@if ($errors->has('engine'))' +
                        '<div class="invalid-feedback">' +
                            '<strong>{{ $errors->first('engine') }}</strong>' +
                            '</div>' +
                            '@endif' +
                            '</div>' +

                            '<div class="form-group{{ $errors->has('ecu') ? ' has-error' : '' }} col-md-2">' +
                                '<label for="ecu" class="control-label">ECU</label>' +
                                '<input id="ecu" type="text"class="form-control{{ $errors->has('ecu') ? ' is-invalid' : '' }} " name="ecu"  required="required" placeholder="Enter ECU"value="{{ old('ecu') }}">' +
                                '@if ($errors->has('ecu'))' +
                                '<div class="invalid-feedback">' +
                                    ' <strong>{{ $errors->first('ecu') }}</strong>' +
                                    '</div>' +
                                    '@endif ' +
                                    '</div>';
        $('.changeInputs').append(value);
        $('.hideLink').empty();
    });

    $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: 'https://tuning.bpslab.co.za/api.tuning',
                data: {action: 'getVehicleBrand',values: {vehicleType: 'Cars'}},
                success: function( msg ) { 
    
                    let res = JSON.parse(msg)
                    //console.log(res);
                   for (i = 0; i < res.length; i++) {
                    {{--  console.log(res[i]);  --}}
                        $('#make').append($('<option>', { 
                            value: res[i].name+'--'+msg[i].name,
                            text : res[i].name 
                        }));
                      }

                      
                }
            });

      });


    $('#make').on('change', function(){
        $.ajax({
            type: "POST",
            url: 'https://tuning.bpslab.co.za/api.tuning',
            data: {action: 'getVehicleModels',values: {vehicleType: 1,brandType: $('#make').val().split('--')[0]}},
            success: function( msg ) { 

                let res = JSON.parse(msg)
                console.log(res);
                $("#model option").remove();
                $('#model').append($('<option>', { 
                    value: '',
                    text : 'Choose a model'
                }));

                $("#generation option").remove();
                $('#generation').append($('<option>', { 
                    value: '',
                    text : 'Choose a generation'
                }));

                $("#engine option").remove();
                $('#engine').append($('<option>', { 
                    value: '',
                    text : 'Choose an engine'
                }));

                $("#ecu option").remove();
                $('#ecu').append($('<option>', { 
                    value: '',
                    text : 'Choose a ECU'
                }));

               for (i = 0; i < res.length; i++) {
                $('#model').append($('<option>', { 
                    value: res[i].name+'--'+ res[i].id,
                    text : res[i].name 
                }));
                }
            }
        });
    });

    $('#model').on('change', function(){
        $.ajax({
            type: "POST",
            url: 'https://tuning.bpslab.co.za/api.tuning',
            data: {action: 'getVehicleModelYears',values: {vehicleType: 1,brandType: $('#make').val().split('--')[0], vehicleModel: $('#model').val().split('--')[1]}},
            success: function( msg ) { 

                let res = JSON.parse(msg)
                $("#generation option").remove();
                $('#generation').append($('<option>', { 
                    value: '',
                    text : 'Choose a generation'
                }));

                $("#engine option").remove();
                $('#engine').append($('<option>', { 
                    value: '',
                    text : 'Choose an engine'
                }));

                $("#ecu option").remove();
                $('#ecu').append($('<option>', { 
                    value: '',
                    text : 'Choose a ECU'
                }));

               for (i = 0; i < res.length; i++) {
                $('#generation').append($('<option>', { 
                    value: res[i].long_name +'--'+ res[i].id,
                    text : res[i].long_name 
                }));
                }

            }
        });
    });

    $('#generation').on('change', function(){
        $.ajax({
            type: "POST",
            url: 'https://tuning.bpslab.co.za/api.tuning',
            data: {action: 'getVehiclePowertrains',values: {vehicleType: 1,brandType: $('#make').val().split('--')[0], vehicleModel: $('#model').val().split('--')[1], vehicleModelYear: $('#generation').val().split('--')[1]}},
            success: function( msg ) { 

                let res = JSON.parse(msg)
                $("#engine option").remove();
                $('#engine').append($('<option>', { 
                    value: '',
                    text : 'Choose an engine'
                }));

                $("#ecu option").remove();
                $('#ecu').append($('<option>', { 
                    value: '',
                    text : 'Choose a ECU'
                }));


               for (i = 0; i < res.length; i++) {
                $('#engine').append($('<option>', { 
                    value: res[i].engine.name +' '+ res[i].engine.power +'hp' + '/' + res[i].id,
                    text : res[i].engine.name +' '+ res[i].engine.power +'hp'
                }));
                }

            }
        });
    });

    
    
    function addrows(){
        $('.remove_tuning_options').remove();
        $.ajax({
            type: "GET",
            url: '/tuning_types/'+ $('#tuning_type').val()+'/tuning_options/'+ $('#tuning_type').val(),
            success: function( msg ) { 
    
                $.each(msg.response, function( index, value ) {
                    var value = '<div class="form-group col-md-4 remove_tuning_options">' +
                        '<div class="custom-control custom-checkbox">' +
                            '<input type="checkbox" name="tuning_options[]" class="custom-control-input" id="defaultUnchecked' +index+ '" value="'+value.id +'">' +
                            '<label class="custom-control-label" for="defaultUnchecked' + index +'">'+ value.label +' ('+value.credits+')'+'</label>' +
                        '</div>' +
                        
                    '</div>';
                    $('.addcheckbox').append(value);
                  });
                $("#ajaxResponse").append("<div>"+msg+"</div>");

            }
        });
    
       
    }

    {{-- Original file upload script --}}

    function downloadOriginalFile(){
        $('#original_file').val('');
        $('#originalFile').empty();
        $('#empltyoriginalFile').show();
        $('.import').empty();
        $('.deleteOriginalFile').empty();
    }

      function encodeImgtoBase64(element) {
 
        var img = element.files[0];
   
        var reader = new FileReader();
   
        reader.onloadend = function() {
            $('.import').empty();
            //$('#originalFile').empty();
            $(".import").append('<a href="'+reader.result+'" download="'+element.files[0].name+'"><i class="fa fa-download"></i></a>');
            $('.deleteOriginalFile').empty();
            $(".deleteOriginalFile").append('<a class="" href="#" onclick="downloadOriginalFile();"><i class="fa fa-trash"></i></a>');
        }
        reader.readAsDataURL(img);
      }
      

    


    function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          encodeImgtoBase64(input);

          reader.onload = function(e) {
            $('#empltyoriginalFile').hide();
            $('.exist').hide();
            $('.existFile').hide();
            $('.notExistFile').show();
            $('.notExist').show();
            $('#originalFile').empty();
            $('#originalFile').append('<i class="fa fa-file"></i> <br>');
            $('#originalFile').append(input.files[0].name);
          };
      
          reader.readAsDataURL(input.files[0]);
      
        } else {
          removeUpload();
        }
      }
      
      function removeUpload() {
        $('#originalFile').empty();
        $('.exist').hide();
        $('.existFile').hide();
        $('.notExistFile').show();
        $('.notExist').show();
        $('#empltyoriginalFile').show();
      }
      {{-- End Original file upload --}}

      {{-- Modified file upload script --}}

    function downloadModifiedFile(){
        $('#modified_file').val('');
        $('#modifiedFile').empty();
        $('#empltymodifiedFile').show();
        $('.importModified').empty();
        $('.deleteModifiedFile').empty();
    }

      function encodeImgtoBase64Modified(element) {
 
        var img = element.files[0];
   
        var reader = new FileReader();
   
        reader.onloadend = function() {
            $('.importModified').empty();
            //$('#modifiedFile').empty();
            $(".importModified").append('<a href="'+reader.result+'" download="'+element.files[0].name+'"><i class="fa fa-download"></i></a>');
            $('.deleteModifiedFile').empty();
            $(".deleteModifiedFile").append('<a class="" href="#" onclick="downloadModifiedFile();"><i class="fa fa-trash"></i></a>');
        }
        reader.readAsDataURL(img);
      }
      

    


    function readURLModified(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          encodeImgtoBase64Modified(input);

          reader.onload = function(e) {
              $('#empltymodifiedFile').hide();
              $('.existModified').hide();
              $('.existFileModified').hide();
              $('.notExistFileModified').show();
              $('.notExistModified').show();
              $('#modifiedFile').empty();
              $('#modifiedFile').prepend(input.files[0].name);
              $('#modifiedFile').prepend('<i class="fa fa-file"></i> <br>');
        };
          reader.readAsDataURL(input.files[0]);
        } else {
            removeUploadModified();
        }
      }
      
      function removeUploadModified() {
        $('#modifiedFile').empty();
        $('.existModified').hide();
        $('.existFileModified').hide();
        $('.notExistFileModified').show();
        $('.notExistModified').show();
        $('#empltymodifiedFile').show();
      }

      {{-- End modified file upload --}}

      {{-- Dynograph file upload script --}}

    function downloadDynographFile(){
        $('#dynograph_file').val('');
        $('#dynographFile').empty();
        $('#empltydynographFile').show();
        $('.importDynograph').empty();
        $('.deleteDynographFile').empty();
    }

      function encodeImgtoBase64Dynograph(element) {
 
        var img = element.files[0];
   
        var reader = new FileReader();
   
        reader.onloadend = function() {
            $('.importDynograph').empty();
            $('#dynographFile').empty();
            $(".importDynograph").append('<a href="'+reader.result+'" download="'+element.files[0].name+'"><i class="fa fa-download"></i></a>');
            $('.deleteDynographFile').empty();
            $(".deleteDynographFile").append('<a class="" href="#" onclick="downloadDynographFile();"><i class="fa fa-trash"></i></a>');
        }
        reader.readAsDataURL(img);
      }
      

    


    function readURLDynograph(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          encodeImgtoBase64Dynograph(input);

          reader.onload = function(e) {
            $('#empltydynographFile').hide();
            $('.existDynograph').hide();
            $('.existFileDynograph').hide();
            $('.notExistFileDynograph').show();
            $('.notExistDynograph').show();
            $('#dynographFile').empty();
            $('#dynographFile').append('<i class="fa fa-file"></i> <br>');
            $('#dynographFile').append(input.files[0].name);
          };
      
          reader.readAsDataURL(input.files[0]);
      
        } else {
            removeUploadDynograph();
        }
      }
      
      function removeUploadDynograph() {
        $('#dynographFile').empty();
        $('.existDynograph').hide();
        $('.existFileDynograph').hide();
        $('.notExistFileDynograph').show();
        $('.notExistDynograph').show();
        $('#empltydynographFile').show();
      }

      {{-- End dynograph
         file upload --}}

      {{--  ticket script  --}}
      $(document).ready(function(){
        $.ajax({
            type: "POST",
            url: 'https://tuning.bpslab.co.za/api.tuning',
            data: {action: 'getVehicleBrand',values: {vehicleType: 'Cars'}},
            success: function( msg ) { 

                let res = JSON.parse(msg)
                //console.log(res);
               for (i = 0; i < res.length; i++) {

                    $('#make').append($('<option>', { 
                        value: res[i].name,
                        text : res[i].name 
                    }));
                  }

                  
            }
        });

  });


$('#category_id').on('change', function(){
    if($("#category_id option:selected").html() == 'File service'){
        $('.RemoveInput').remove();
        var fileService = '<div class="form-group{{ $errors->has('file_service_id') ? ' has-error' : '' }} RemoveInput"> ' +
            '<label for="file_service_id" class="control-label">File service</label>' +
            '<select class="form-control{{ $errors->has('file_service_id') ? ' is-invalid' : '' }} click" required="required" id="file_service_id" name="file_service_id">' +
                '<option value="">Choose a file service</option>' +
            '</select>' +
            '@if ($errors->has('file_service_id'))' +
            '<div class="invalid-feedback">' +
                    '<strong>{{ $errors->first('file_service_id') }}</strong>' +
                '</div>' +
            '@endif' +
        '</div>';
        $('.dyanamicInput').append(fileService);

        $.ajax({
            type: "GET",
            url: '/tickitFileService/',
            success: function( data ) { 
                for (i = 0; i < data.response.length; i++) {
                    $('#file_service_id').append($('<option>', { 
                        value: data.response[i].id,
                        text : data.response[i].make +' '+ data.response[i].model +' '+ data.response[i].engine
                    }));
                  }
            }
        });

    }else if($("#category_id option:selected").html() == 'General question'){
        $('.RemoveInput').remove();
        var generalQuetion = 
            '<div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }} RemoveInput">' +
                '<label for="subject" class="control-label">Subject</label>' +
                '<input id="subject" type="text"' +
                        'class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }} "' +
                        'name="subject"' +
                        'value="{{ old('subject') }}"  required>' +
                '@if ($errors->has('subject'))' +
                    '<div class="invalid-feedback">' +
                       '<strong>{{ $errors->first('subject') }}</strong>' +
                    '</div>' +
                '@endif' +
        '</div>';
        $('.dyanamicInput').append(generalQuetion);
    }else{
        $('.RemoveInput').remove();
    }
   
});
    
       
     </script>

<!-- Custom Scripts -->
@yield('scripts')