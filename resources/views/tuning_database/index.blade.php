@extends('layouts.plain')
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tuning Database Form</title>
</head>
<body>
    <div id="overlay" >
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    <div class="row" style="margin-top:70px; ">
      <div class="col-md-6 offset-md-3" style="background-color: #15547b!important;">
          <div class="container  text-white  justify-content-center"><br>
            <div class="card-body text-center">
              <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="90" align="center">
            </div>
            <div class="col-sm-12 ml-md-0 col-md-12">
              <div class="container flex-center" style="padding-top: 100px">
                  <div class="header text-center lex-wrap mx-0">
                      <h2><b>BROWSE OUR TUNING FILES</b></h2>      
                      <p class="subtune">Freely browse all our tuning file specifications below.</p>           
                  </div>
                  <form>
                      
                      <div class="form-row">
                      <div class="form-group col-md-6 col-lg-6">
                          <!--<label for="make_id" class="col-form-label">Brands</label>-->
                          <select id="make_id" class="form-control dropdown-toggle cars" name="make_id"  >
                              <option value="">Choose a make</option>
                          </select>
                      </div>
                 
                      <div class="form-group col-md-6 col-lg-6">
                          <!--<label for="model_id" class="col-form-label">Models</label> -->
                          <select id="model_id" class="form-control models" name="model_id">
                            <option value="">Choose a model</option>
                          </select>
                      </div>
                 
                      <div class="form-group col-md-6 col-lg-6">
                          <!--<label for="generation_id" class="col-form-label">Model Years</label> -->
                          <select id="generation_id" class="form-control generation" name="generation_id">
                             <option value="">Choose a generation</option>
                          </select>
                      </div>
                 
                      <div class="form-group col-md-6 col-lg-6">
                          <!--<label for="engine_id" class="col-form-label">Powertrains</label> -->
                          <select id="engine_id" class="form-control engine" name="engine_id">
                              <option value="">Choose an engine</option>
                          </select>
                      </div>
                    </div>
                 </form>
              </div>
              <div class="container flex-center">
                  <div id="vehicle" style="margin: 0 0 2% 2%;"></div>
                  <div id="engine" style="margin: 0 0 2% 2%;"></div>
                <div id="rootView1" style="margin: 0 0 2% 2%;"></div>
                <div id="rootView" style="margin: 0 0 2% 2%;;"></div>
              </div>
          </div>
          </div>
          
        </div>
  </div>
    {{-- <div class="container gid"style="margin-top:70px; " >
        <div class="row  shadow-lg bg-white">
            <div class="col-sm-4 col-md-4 bg-dark">
                <div class="container  text-white  justify-content-center"><br>
                    <div class="card-body text-center">
                        <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="90" align="center"">
                    </div>
                <br>
                    <div class="row text-center">
                        <div class="card-body text-center">
                            <a href="{{ url('/') }}" id="login" class="back text-white">Login</a>
                        </div>
                    </div>
                <br>
            </div>
        </div>
        <div class="col-sm-12 ml-md-0 col-md-8">
            <div class="container flex-center" style="padding-top: 100px">
                <div class="header text-center lex-wrap mx-0">
                    <h2><b>BROWSE OUR TUNING FILES</b></h2>      
                    <p class="subtune">Freely browse all our tuning file specifications below.</p>           
                </div>
                <form>
                    
                    <div class="form-row">
                    <div class="form-group col-md-3">
                        <!--<label for="make_id" class="col-form-label">Brands</label>-->
                        <select id="make_id" class="form-control dropdown-toggle cars" name="make_id"  >
                            <option value="">Choose a make</option>
                        </select>
                    </div>
               
                    <div class="form-group col-md-3">
                        <!--<label for="model_id" class="col-form-label">Models</label> -->
                        <select id="model_id" class="form-control models" name="model_id">
                          <option value="">Choose a model</option>
                        </select>
                    </div>
               
                    <div class="form-group col-md-3">
                        <!--<label for="generation_id" class="col-form-label">Model Years</label> -->
                        <select id="generation_id" class="form-control generation" name="generation_id">
                           <option value="">Choose a generation</option>
                        </select>
                    </div>
               
                    <div class="form-group col-md-3">
                        <!--<label for="engine_id" class="col-form-label">Powertrains</label> -->
                        <select id="engine_id" class="form-control engine" name="engine_id">
                            <option value="">Choose an engine</option>
                        </select>
                    </div>
                  </div>
               </form>
            </div>
            <div class="container flex-center">
                <div id="vehicle" style="margin: 0 0 2% 2%;"></div>
                <div id="engine" style="margin: 0 0 2% 2%;"></div>
              <div id="rootView1" style="margin: 0 0 2% 2%;"></div>
              <div id="rootView" style="margin: 0 0 2% 2%;;"></div>
            </div>
        </div>
    </div> --}}
</body>
</html>

<script>
$(document).ready(function(){
    $.ajax({
        type: "POST",
        url: 'https://tuning.bpslab.co.za/api.tuning',
        data: {action: 'getVehicleBrand',values: {vehicleType: 'Cars'}},
        success: function( msg ) { 

            let res = JSON.parse(msg)
            {{--  //console.log(res);  --}}
           for (i = 0; i < res.length; i++) {

                $('#make_id').append($('<option>', { 
                    value: res[i].name,
                    text : res[i].name 
                }));
              } 
        }
    });

});

$('#make_id').on('change', function(){
    $.ajax({
        type: "POST",
        url: 'https://tuning.bpslab.co.za/api.tuning',
        data: {action: 'getVehicleModels',values: {vehicleType: 1,brandType: $('#make_id').val()}},
        success: function( msg ) { 

            let res = JSON.parse(msg)
            //console.log(res);
            $("#model_id option").remove();
            $('#model_id').append($('<option>', { 
                value: '',
                text : 'Choose a model'
            }));

            $("#generation_id option").remove();
            $('#generation_id').append($('<option>', { 
                value: '',
                text : 'Choose a generation'
            }));

            $("#engine_id option").remove();
            $('#engine_id').append($('<option>', { 
                value: '',
                text : 'Choose an engine'
            }));

           for (i = 0; i < res.length; i++) {
            $('#model_id').append($('<option>', { 
                value: res[i].name,
                text : res[i].name 
            }));
            }
        }
    });
});

$('#model_id').on('change', function(){
    $.ajax({
        type: "POST",
        url: 'https://tuning.bpslab.co.za/api.tuning',
        data: {action: 'getVehicleModelYears',values: {vehicleType: 1,brandType: $('#make_id').val(), vehicleModel: $('#model_id').val()}},
        success: function( msg ) { 

            let res = JSON.parse(msg)
            $("#generation_id option").remove();
            $('#generation_id').append($('<option>', { 
                value: '',
                text : 'Choose a generation'
            }));

            $("#engine_id option").remove();
            $('#engine_id').append($('<option>', { 
                value: '',
                text : 'Choose an engine'
            }));

           for (i = 0; i < res.length; i++) {
            $('#generation_id').append($('<option>', { 
                value: res[i].id,
                text : res[i].long_name 
            }));
            }

        }
    });
});

$('#generation_id').on('change', function(){
    $.ajax({
        type: "POST",
        url: 'https://tuning.bpslab.co.za/api.tuning',
        data: {action: 'getVehiclePowertrains',values: {vehicleType: 1,brandType: $('#make_id').val(), vehicleModel: $('#model_id').val(), vehicleModelYear: $('#generation_id').val()}},
        success: function( msg ) { 

            let res = JSON.parse(msg)
            $("#engine_id option").remove();
            $('#engine_id').append($('<option>', { 
                value: '',
                text : 'Choose an engine'
            }));

           for (i = 0; i < res.length; i++) {
            $('#engine_id').append($('<option>', { 
                value: res[i].id,
                text : res[i].engine.name +' '+ res[i].engine.power +'hp'
            }));
            }

        }
    });
});

$('#engine_id').on('change', function(){
    let selectVal4 = $("#engine_id option:selected").val();
            let res = selectVal4.split("_");
            var make = $("#make_id option:selected").text();
            var model = $("#model_id option:selected").text();
            var generation = $("#generation_id option:selected").text();
            var engine = $("#engine_id option:selected").text();
            let logo;
            
             

            $(".tableDiv").remove();
            $(".py-4").remove();
            $(".vehicle").remove();
            $(".engineDiv").remove();
            $(".option").remove();
            if($("#engine_id option:selected").val()){
                $.ajax({
                    type: "POST",
                    url: 'https://tuning.bpslab.co.za/api.tuning',
                    data: {action: 'getVehicleLog',values: {vehicleType: 1,brandType: res[0]}},
                    success: function( msg ) { 
            
                        logo = JSON.parse(msg);
                        console.log(logo);
            
                        $.ajax({
                            type: "POST",
                            url: 'https://tuning.bpslab.co.za/api.tuning',
                            data: {action: 'getPowertrainsResult',values: {vehicleType: 1,brandType: $('#make_id').val(), vehicleModel: $('#model_id').val(), vehicleModelYear: $('#generation_id').val(),powertrainsId: $('#engine_id').val()}},
                            success: function( options1 ) { 
                                let options = JSON.parse(options1);
                                console.log(options.engine.stages);
                                let count = 0;
                                var navTabs;
                                var tab;
                                var tabPane;
                                var vehicle;
                                var engineDiv;
                                var optionsDiv;
                                
                                var engineCode;
                                if(options.engine.code){
                                    engineCode = options.engine.code;
                                }else{
                                    engineCode = '-'
                                }
                                engineDiv = '<div class="row engineDiv" >'+
                                                  '<div class="col-md-12">'+
                                                    '<h3 style="font-weight: bolder;">Engine specifications</h3>'+
                                                  '</div>'+
                                                '<div class="col-6">'+
                                                '<div class="row">'+
                                                  '<div class="col-12">'+
                                                    '<div class="row">'+
                                                      '<div class="col-5">Engine:</div>'+
                                                      '<div class="col-7">'+
                                                      '<strong>'+options.engine.name+'</strong>'+
                                                      '<div>'+
                                                    '</div>'+
                                                  '</div>'+
                                                  '<div class="col-12">'+
                                                    '<div class="row">'+
                                                      '<div class="col-5">Fuel:</div>'+
                                                      '<div class="col-7">'+
                                                       '<strong>'+options.engine.fuel_type+'</strong>'+
                                                      '</div>'+
                                                    '</div>'+
                                                  '</div>'+
                                                  '<div class="col-12">'+
                                                    '<div class="row">'+
                                                      '<div class="col-5">Code:</div>'+
                                                      '<div class="col-7">'+
                                                       '<strong>'+engineCode+'</strong>'+
                                                      '</div>'+
                                                    '</div>'+
                                                  '</div>'+
                                                  '<div class="col-12">'+
                                                    '<div class="row">'+
                                                      '<div class="col-5">Power:</div>'+
                                                      '<div class="col-7">'+
                                                       '<strong>'+options.engine.power+'hp</strong>'+
                                                      '</div>'+
                                                    '</div>'+
                                                  '</div>'+
                                                  '<div class="col-12">'+
                                                    '<div class="row">'+
                                                      '<div class="col-5">Torque:</div>'+
                                                      '<div class="col-7">'+
                                                       '<strong>'+options.engine.torque+'nm</strong>'+
                                                      '</div>'+
                                                    '</div>'+
                                                  '</div>'+
                                                '</div>'+
                                                '</div>';
                                                            
                                $('#engine').append(engineDiv);
                                vehicle = '<div class="row vehicle">'+
                                              '<div class="col-12">'+
                                                  '<h3 style="font-weight: bolder;">Your Vehicle</h3>'+
                                              '</div>'+
                                            
                                              '<div class="col-12">'+
                                                '<div class="row">'+
                                                  '<div class="col-4 col-md-4">'+
                                                    '<div class="card">'+
                                                    '<img src="'+logo+'" alt="" style="height: 120px;object-fit: scale-down;">'+
                                                    '</div>'+
                                                  '</div>'+
                                                  '<div class="col-8 col-md-6">'+
                                                    '<h3>'+ make+'</h3>'+
                                                    '<h4>'+ model+' '+generation+'</h4>'+
                                                    '<h4>'+ engine+'</h4>'+
                                                  '</div>'+
                                
                                                '</div>'+
                                              '</div>'+
                                            
                                            '</div>';
                                                            
                                $('#vehicle').append(vehicle);
                                
                                navTabs = '<div class="py-4">'+
                                                '<h3 style="font-weight: bolder;">Tuning perfomance</h3>'+
                                              '<div class="row">'+
                                                  '<div class="col-md-12">'+
                                                      '<ul id="tabs" class="nav nav-tabs">'+ 
                                                      '</ul>'+
                                                      '<br>'+
                                                      '<div id="tabsContent" class="tab-content">'+
                                                      '</div>'+
                                                  '</div>'+
                                              '</div>'+
                                            '</div>';
                                $('#rootView1').append(navTabs);
                                    
                                for (let i = 0; i < options.engine.stages.length; i++) {
                                    const element = options.engine.stages[i];
                                    count ++;
                                    let div = document.createElement('div');
                                    const oop = options.options.en;
                                    let o1 = oop.join('  |  ')
                                    div.id = 'content';
                                    var powerDefference = options.engine.stages[i].power-options.engine.power;
                                    var torgueDefference = options.engine.stages[i].torque-options.engine.torque;
                                    var activeTabPane, activeTab;
                                    
                                    if(options.engine.stages.length == 1 || i == 0){
                                        activeTabPane = 'active show'
                                        activeTab = 'active'
                                    }else{
                                        activeTab = '';
                                        activeTabPane = '';
                                    }
                    
                                    tab = '<li class="nav-item"><a href="" data-target="#'+options.engine.stages[i].id+'" data-toggle="tab" class="nav-link small text-uppercase '+activeTab+'">'+ options.engine.stages[i].name +'</a></li>';
                                    
                                    tabPane = '<div id="'+options.engine.stages[i].id+'" class="tab-pane fade '+activeTabPane+'">'+
                                                    '<table class="table table-striped table-bordered table-responsive text-white" style="width:100%">'+
                                                      '<thead>'+
                                                      '<tr>'+
                                                        '<th>&nbsp;</th>'+
                                                        '<th>STANDARD</th>'+
                                                        '<th style="color">CHIPTUNING</th>'+
                                                        '<th>DIFFERENCE</th>'+
                                                        '</tr>'+
                                                      '</thead>'+
                                                      '<tbody>'+
                                                      '<tr class="power">'+
                                                          '<td style="background-color: #25292100"> Power (hp)</td>'+
                                                          '<td>'+options.engine.power+'</td>'+
                                                          '<td style="background-color: #29346a; color: white;">'+options.engine.stages[i].power+'</td>'+
                                                          '<td style="">'+powerDefference+'</td>'+
                                                        '</tr>'+
                                                      '<tr class="torque">'+
                                                          '<td style="background-color: #99999910">Torque (Nm)</td>'+
                                                          '<td>'+options.engine.torque +'</td>'+
                                                          '<td style="background-color: #3c86d9">'+options.engine.stages[i].torque+'</td>'+
                                                          '<td style="color: #3c86d9">'+torgueDefference+'</td>'+
                                                        '</tr>'+
                                                      '</tbody>'+
                                                    '</table>'
                                                  '</div>';
                                    
                                    $('.nav-tabs').append(tab);
                                     $('#tabsContent').append(tabPane);
                                }
                                
                                
                                
                                if(options.options.en.length > 0){
                                    var optionsDiv1 = '<div class="row option">'+
                                                          '<div class="col-md-12">'+
                                                            '<h3 style="font-weight: bolder;">Available options</h3>'+
                                                          '</div>'+
                                                        '</div>';
                                    $('#rootView').append(optionsDiv1);
                                    for (let i = 0; i < options.options.en.length; i++) {
                                        optionsDiv = '<div class="col-md-3">'+
                                                  '<div class="card">'+
                                                    '<div class="card-header text-dark">'+options.options.en[i]+'</div>'+
                                                  '</div>'+
                                                '</div>';
                                    $('.option').append(optionsDiv);
                                    }
                                }
                            }
                        });
                    }
                });
            }
});

window.onload=function(){

        $('.engine111').on('change', function () {
            let selectVal4 = $(".engine option:selected").val();
            let res = selectVal4.split("_");
            var make = $("#make_id option:selected").text();
            var model = $(".models option:selected").text();
            var generation = $(".generation option:selected").text();
            var engine = $(".engine option:selected").text();
            let logo;
            
             

            $(".tableDiv").remove();
            $(".py-4").remove();
            $(".vehicle").remove();
            $(".engineDiv").remove();
            $(".option").remove();
            
            easyAjax(baseUrl, {action: 'getVehicleLog', values: {vehicleType: '1', brandType: res[0]}}, function(options1) { 
                logo = options1;
                easyAjax(baseUrl, {action: 'getPowertrainsResult', values: {vehicleType: '1', brandType: res[0], vehicleModel: res[1], vehicleModelYear:res[2], powertrainsId: res[3]}}, function(options) {
                let count = 0;
                var navTabs;
                var tab;
                var tabPane;
                var vehicle;
                var engineDiv;
                var optionsDiv;
                
                var engineCode;
                if(options.engine.code){
                    engineCode = options.engine.code;
                }else{
                    engineCode = '-'
                }
                engineDiv = '<div class="row engineDiv" >'+
                                  '<div class="col-md-12">'+
                                    '<h3 style="font-weight: bolder;">Engine specifications</h3>'+
                                  '</div>'+
                                '<div class="col-md-6">'+
                                '<div class="row">'+
                                  '<div class="col-md-12">'+
                                    '<div class="row">'+
                                      '<div class="col-md-6">Engine:</div>'+
                                      '<div class="col-md-6">'+
                                      '<strong>'+options.engine.name+'</strong>'+
                                      '<div>'+
                                    '</div>'+
                                  '</div>'+
                                  '<div class="col-md-12">'+
                                    '<div class="row">'+
                                      '<div class="col-md-6">Fuel:</div>'+
                                      '<div class="col-md-6">'+
                                       '<strong>'+options.engine.fuel_type+'</strong>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                  '<div class="col-md-12">'+
                                    '<div class="row">'+
                                      '<div class="col-md-6">Code:</div>'+
                                      '<div class="col-md-6">'+
                                       '<strong>'+engineCode+'</strong>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                  '<div class="col-md-12">'+
                                    '<div class="row">'+
                                      '<div class="col-md-6">Power:</div>'+
                                      '<div class="col-md-6">'+
                                       '<strong>'+options.engine.power+'hp</strong>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                  '<div class="col-md-12">'+
                                    '<div class="row">'+
                                      '<div class="col-md-6">Torque:</div>'+
                                      '<div class="col-md-6">'+
                                       '<strong>'+options.engine.torque+'nm</strong>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>'+
                                '</div>';
                                            
                $('#engine').append(engineDiv);
                vehicle = '<div class="row vehicle">'+
                              '<div class="col-md-12">'+
                                  '<h3 style="font-weight: bolder;">Your Vehicle</h3>'+
                              '</div>'+
                            
                              '<div class="col-md-12">'+
                                '<div class="row">'+
                                  '<div class="col-md-2">'+
                                    '<div class="card">'+
                                    '<img src="'+logo+'" alt="" style="height: 120px;object-fit: scale-down;">'+
                                    '</div>'+
                                  '</div>'+
                                  '<div class="col-md-6">'+
                                    '<h3>'+ make+'</h3>'+
                                    '<h4>'+ model+' '+generation+'</h4>'+
                                    '<h4>'+ engine+'</h4>'+
                                  '</div>'+
                
                                '</div>'+
                              '</div>'+
                            
                            '</div>';
                                            
                $('#vehicle').append(vehicle);
                
                navTabs = '<div class="py-4">'+
                                '<h3 style="font-weight: bolder;">Tuning perfomance</h3>'+
                              '<div class="row">'+
                                  '<div class="col-md-12">'+
                                      '<ul id="tabs" class="nav nav-tabs">'+ 
                                      '</ul>'+
                                      '<br>'+
                                      '<div id="tabsContent" class="tab-content">'+
                                      '</div>'+
                                  '</div>'+
                              '</div>'+
                            '</div>';
                $('#rootView1').append(navTabs);
                    
                for (let i = 0; i < options.engine.stages.length; i++) {
                    const element = options.engine.stages[i];
                    count ++;
                    let div = document.createElement('div');
                    const oop = options.options.en;
                    let o1 = oop.join('  |  ')
                    div.id = 'content';
                    var powerDefference = options.engine.stages[i].power-options.engine.power;
                    var torgueDefference = options.engine.stages[i].torque-options.engine.torque;
                    var activeTabPane, activeTab;
                    
                    if(options.engine.stages.length == 1 || i == 0){
                        activeTabPane = 'active show'
                        activeTab = 'active'
                    }else{
                        activeTab = '';
                        activeTabPane = '';
                    }
    
                    tab = '<li class="nav-item"><a href="" data-target="#'+options.engine.stages[i].id+'" data-toggle="tab" class="nav-link small text-uppercase '+activeTab+'">'+ options.engine.stages[i].name +'</a></li>';
                    
                    tabPane = '<div id="'+options.engine.stages[i].id+'" class="tab-pane fade '+activeTabPane+'">'+
                                    '<table class="table">'+
                                      '<thead>'+
                                      '<tr>'+
                                        '<th>&nbsp;</th>'+
                                        '<th>STANDARD</th>'+
                                        '<th style="color">CHIPTUNING</th>'+
                                        '<th>DIFFERENCE</th>'+
                                        '</tr>'+
                                      '</thead>'+
                                      '<tbody>'+
                                      '<tr class="power">'+
                                          '<td style="background-color: #25292100"> Power (hp)</td>'+
                                          '<td>'+options.engine.power+'</td>'+
                                          '<td style="background-color: #29346a; color: white;">'+options.engine.stages[i].power+'</td>'+
                                          '<td style="">'+powerDefference+'</td>'+
                                        '</tr>'+
                                      '<tr class="torque">'+
                                          '<td style="background-color: #99999910">Torque (Nm)</td>'+
                                          '<td>'+options.engine.torque +'</td>'+
                                          '<td style="background-color: #3c86d9">'+options.engine.stages[i].torque+'</td>'+
                                          '<td style="color: #3c86d9">'+torgueDefference+'</td>'+
                                        '</tr>'+
                                      '</tbody>'+
                                    '</table>'
                                  '</div>';
                    
                    $('.nav-tabs').append(tab);
                     $('#tabsContent').append(tabPane);
                }
                
                
                
                if(options.options.en.length > 0){
                    var optionsDiv1 = '<div class="row option">'+
                                          '<div class="col-md-12">'+
                                            '<h3 style="font-weight: bolder;">Available options</h3>'+
                                          '</div>'+
                                        '</div>';
                    $('#rootView').append(optionsDiv1);
                    for (let i = 0; i < options.options.en.length; i++) {
                        optionsDiv = '<div class="col-md-3">'+
                                  '<div class="card">'+
                                    '<div class="card-header">'+options.options.en[i]+'</div>'+
                                  '</div>'+
                                '</div>';
                    $('.option').append(optionsDiv);
                    }
                }
                
            }, {})
                
            }, {})
        });
        
        
        jQuery(function($){
        	$(document).ajaxSend(function() {
        		$("#overlay").fadeIn(300);　
        	});
        	
        	$(document).ajaxComplete(function(){
                $("#overlay").fadeOut(300);
            });
        });
}
</script>