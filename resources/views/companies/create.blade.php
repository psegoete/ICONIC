{{--  @extends('account.layouts.default')  --}}
@extends('layouts.app')


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Iconic Code Development</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  {{-- <link rel="stylesheet" type="text/css" href="https://parsleyjs.org/src/parsley.css"> --}}
{{-- <script src="https://parsleyjs.org/dist/parsley.min.js"></script> --}}
  <style>
       .modal-dialog, .modal-full {
		min-width: 100%;
		margin: 0;
	}
	
.close {
  float: right;
  font-size: 21px;
  font-weight: 700;
  line-height: 1;
  color: #3931af;
  text-shadow: 0 1px 0 #fff;
  
}
	
	.register{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    margin-top: 0.5%;
    padding: 3%;
}
.register-left{
    text-align: center;
    color: #fff;
    margin-top: 4%;
}
.register-left input{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}
.register-right{
    background: #f8f9fa;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
}
.register-left img{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 25%;
    -webkit-animation: mover 2s infinite  alternate;
    animation: mover 1s infinite  alternate;
}
@-webkit-keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
.register-left p{
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
}
.register .register-form{
    padding: 10%;
    margin-top: 10%;
}
.btnRegister{
    float: right;
    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
}
.register .nav-tabs{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}
.register .nav-tabs .nav-link{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}
.register .nav-tabs .nav-link:hover{
    border: none;
}
.register .nav-tabs .nav-link.active{
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}
.register-heading{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}

#container{
	margin-top:120px; margin-bottom:50px;
}

.phpdebugbar{
    display: none;
  }

  .Legal {
    position: absolute;
    bottom: 8px;
    right: 8px;
    left: 8px;
    font-size: .857rem;
    padding: 4px 16px;
    z-index: 2;
    text-align: center;
}
.Legal1 {
    position: absolute;
    bottom: 8px;
    right: 8px;
    left: 8px;
    font-size: .857rem;
    padding: 4px 16px;
    z-index: 2;
    text-align: center;
}

/* wizard form */

.form-box {
	padding-top: 40px;
	padding-bottom: 40px;
	
	background: rgb(234,88,4); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(234,88,4,1) 0%, rgba(234,40,3,1) 51%, rgba(234,88,4,1) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(234,88,4,1) 0%,rgba(234,40,3,1) 51%,rgba(234,88,4,1) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(234,88,4,1) 0%,rgba(234,40,3,1) 51%,rgba(234,88,4,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ea5804', endColorstr='#ea5804',GradientType=0 ); /* IE6-9 */
}

.form-wizard {
	padding: 25px; 
	background: #fff;
	-moz-border-radius: 4px; 
	-webkit-border-radius: 4px; 
	border-radius: 4px; 
	box-shadow: 0px 0px 6px 3px #777;
	font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-weight: 300;
    color: black !important;
    line-height: 30px;
    text-align: center;
}
	
.form-wizard strong { font-weight: 500; }

.form-wizard a, .form-wizard a:hover, .form-wizard a:focus {
	color: #ea2803;
	text-decoration: none;
    -o-transition: all .3s; -moz-transition: all .3s; -webkit-transition: all .3s; -ms-transition: all .3s; transition: all .3s;
}

.form-wizard h1, .form-wizard h2 {
	margin-top: 10px;
	font-size: 38px;
    font-weight: 100;
    color: #555;
    line-height: 50px;
}

.form-wizard h3 {
	font-size: 25px;
    font-weight: 300;
    color: #ea2803;
    line-height: 30px;
	margin-top: 0; 
	margin-bottom: 5px; 
	text-transform: uppercase; 
}

.form-wizard h4 {
	float:left;
	font-size: 20px;
    font-weight: 300;
    color: #ea2803;
    line-height: 26px;
	width:100%;
}
.form-wizard h4  span{
	float:right;
	font-size: 18px;
    font-weight: 300;
    color: #555;
    line-height: 26px;
}

.form-wizard table tr th{font-weight:normal;}

.form-wizard img { max-width: 100%; }

.form-wizard ::-moz-selection { background: #ea2803; color: #fff; text-shadow: none; }
.form-wizard ::selection { background: #ea2803; color: #fff; text-shadow: none; }


.form-control {
	height: 44px;
	width:100%;
    margin: 0;
    padding: 0 20px;
    vertical-align: middle;
    background: #fff;
    border: 1px solid #ddd;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 44px;
    color: #888;
    -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px;
    -moz-box-shadow: none; -webkit-box-shadow: none; box-shadow: none;
    -o-transition: all .3s; -moz-transition: all .3s; -webkit-transition: all .3s; -ms-transition: all .3s; transition: all .3s;
}
.checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"], .radio input[type="radio"], .radio-inline input[type="radio"] {
	position: absolute;
	margin-top: 9px;
	margin-left: -20px;
}

.form-control option:hover, .form-control option:checked  {
    box-shadow: 0 0 10px 100px #ea2803 inset;
}

.form-control:focus {
	outline: 0;
	background: #fff;
    border: 1px solid #ccc;
    -moz-box-shadow: none; -webkit-box-shadow: none; box-shadow: none;
}

.form-control:-moz-placeholder { color: #888; }
.form-control:-ms-input-placeholder { color: #888; }
.form-control::-webkit-input-placeholder { color: #888; }

.form-wizard label { font-weight: 300; }
.form-wizard label span { color:#ea2803; }


.form-wizard .btn {
	min-width: 105px;
	height: 40px;
    margin: 0;
    padding: 0 20px;
    vertical-align: middle;
    border: 0;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 40px;
    color: #fff;
    -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px;
    text-shadow: none;
    -moz-box-shadow: none; -webkit-box-shadow: none; box-shadow: none;
    -o-transition: all .3s; -moz-transition: all .3s; -webkit-transition: all .3s; -ms-transition: all .3s; transition: all .3s;
}

.form-wizard .btn:hover {
	background:#f34727; 
	color: #fff; 
	}
.form-wizard .btn:active { 
	outline: 0; 
	background:#f34727; 
	color: #fff; 
	-moz-box-shadow: none; 
	-webkit-box-shadow: none; 
	box-shadow: none; 
	}
.form-wizard .btn:focus,
.form-wizard .btn:active:focus,
.form-wizard .btn.active:focus { 
	outline: 0; 
	background:#f34727; 
	color: #fff; 
}

.form-wizard .btn.btn-next,
.form-wizard .btn.btn-next:focus,
.form-wizard .btn.btn-next:active:focus, 
.form-wizard .btn.btn-next.active:focus { 
background: #ea2803; 
}

.form-wizard .btn.btn-submit,
.form-wizard .btn.btn-submit:focus,
.form-wizard .btn.btn-submit:active:focus, 
.form-wizard .btn.btn-submit.active:focus { 
background: #ea2803; 
}

.form-wizard .btn.btn-previous,
.form-wizard .btn.btn-previous:focus,
.form-wizard .btn.btn-previous:active:focus, 
.form-wizard .btn.btn-previous.active:focus { 
background: #bbb;
}

.form-wizard .success h3{
	color: #4F8A10;
	text-align: center;
	margin: 20px auto !important;
}
.form-wizard .success .success-icon {
	color: #4F8A10;
	font-size: 100px;
	border: 5px solid #4F8A10;
	border-radius: 100px;
	text-align: center !important;
	width: 110px;
	margin: 25px auto;
}
.form-wizard .progress-bar {
	background-color: #ea2803;
}

.form-wizard-steps{ 
	margin:auto; 
	overflow: hidden; 
	position: relative; 
	margin-top: 20px;
}
.form-wizard-step{
	padding-top:10px !important;
	border:2px solid #fff;
	background:#ccc;
	-ms-transform: skewX(-30deg); /* IE 9 */
    -webkit-transform: skewX(-30deg); /* Safari */
    transform: skewX(-30deg); /* Standard syntax */
}
.form-wizard-step.active{
	background:#ea2803;
}
.form-wizard-step.activated{
	background:#ea2803;
}
.form-wizard-progress { 
	position: absolute; 
	top: 36px;
	left: 0; 
	width: 100%; 
	height: 0px; 
	background: #ea2803;
}
.form-wizard-progress-line { 
	position: absolute; 
	top: 0; 
	left: 0; 
	height: 0px; 
	background: #ea2803; 
}

.form-wizard-tolal-steps-3 .form-wizard-step { 
	position: relative;
	float: left; 
	width: 33.33%; 
	padding: 0 5px; 
}
.form-wizard-tolal-steps-4 .form-wizard-step { 
	position: relative; 
	float: left; 
	width: 25%; 
	padding: 0 5px; 
}
.form-wizard-tolal-steps-5 .form-wizard-step { 
	position: relative;
	float: left;
	width: 20%;
	padding: 0 5px;
}

.form-wizard-step-icon {
	display: inline-block;
	width: 40px; 
	height: 40px; 
	margin-top: 4px; 
	background: #ddd;
	font-size: 16px; 
	color: #777; 
	line-height: 40px;
	-moz-border-radius: 50%; 
	-webkit-border-radius: 50%; 
	border-radius: 50%;
	-ms-transform: skewX(30deg); /* IE 9 */
    -webkit-transform: skewX(30deg); /* Safari */
    transform: skewX(30deg); /* Standard syntax */
}
.form-wizard-step.activated .form-wizard-step-icon {
	background: #ea2803; 
	border: 1px solid #fff; 
	color: #fff; 
	line-height: 38px;
}
.form-wizard-step.active .form-wizard-step-icon {
	background: #fff; 
	border: 1px solid #fff; 
	color: #ea2803; 
	line-height: 38px;
}

.form-wizard-step p { 
	color: #fff;
	-ms-transform: skewX(30deg); /* IE 9 */
    -webkit-transform: skewX(30deg); /* Safari */
    transform: skewX(30deg); /* Standard syntax */
}
.form-wizard-step.activated p { color: #fff; }
.form-wizard-step.active p { color: #fff; }

.form-wizard fieldset { 
	display: none; 
	text-align: left; 
	border:0px !important
}

.form-wizard-buttons { text-align: right; }

.form-wizard .input-error { border-color: #ea2803;}

/** image uploader **/
.image-upload a[data-action] {
  cursor: pointer;
  color: #555;
  font-size: 18px;
  line-height: 24px;
  transition: color 0.2s;
}
.image-upload a[data-action] i {
  width: 1.25em;
  text-align: center;
}
.image-upload a[data-action]:hover {
  color: #ea2803;
}
.image-upload a[data-action].disabled {
  opacity: 0.35;
  cursor: default;
}
.image-upload a[data-action].disabled:hover {
  color: #555;
}
.settings_wrap{
	margin-top:20px;
}
.image_picker .settings_wrap {
  overflow: hidden;
  position: relative;
}
.image_picker .settings_wrap .drop_target,
.image_picker .settings_wrap .settings_actions {
  float: left;
}
.image_picker .settings_wrap .drop_target {
  margin-right: 18px;
}
.image_picker .settings_wrap .settings_actions {
	float: left;
	margin-top: 100px;
	margin-left: 20px;
}
.settings_actions.vertical a {
  display: block;
}
.drop_target {
	position: relative;
	cursor: pointer;
	transition: all 0.2s;
    width: 250px;
    height: 250px;
    background: #f2f2f2;
    border-radius: 100%;
    margin: 0 auto 25px auto;
    overflow: hidden;
    border: 8px solid #E0E0E0;
}
.drop_target input[type="file"] {
  visibility: hidden;
}
.drop_target::before {
	content: 'Drop Hear';
	font-family: FontAwesome;
	position: absolute;
	display: block;
	width: 100%;
	line-height: 220px;
	text-align: center;
	font-size: 40px;
	color: rgba(0, 0, 0, 0.3);
	transition: color 0.2s;
}
.drop_target:hover,
.drop_target.dropping {
  background: #f80;
  border-top-color: #cc6d00;
}
.drop_target:hover:before,
.drop_target.dropping:before {
  color: rgba(0, 0, 0, 0.6);
}
.drop_target .image_preview {
  width: 100%;
  height: 100%;
  background: no-repeat center;
  background-size: contain;
  position: relative;
  z-index: 2;
}

{{--  body {
    background-color: #ffffff;
    color: #444444;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-weight: 300;
    margin: 0;
    padding: 0;
  }  --}}
  .wizard-content-left {
    background-blend-mode: darken;
    background-color: rgba(0, 0, 0, 0.45);
    background-image: url("https://i.ibb.co/X292hJF/form-wizard-bg-2.jpg");
    background-position: center center;
    background-size: cover;
    height: 100vh;
    padding: 30px;
  }
  .wizard-content-left h1 {
    color: #ffffff;
    font-size: 38px;
    font-weight: 600;
    padding: 12px 20px;
    text-align: center;
  }
  
  .form-wizard {
    color: #888888;
    padding: 30px;
  }
  .form-wizard .wizard-form-radio {
    display: inline-block;
    margin-left: 5px;
    position: relative;
  }
  .form-wizard .wizard-form-radio input[type="radio"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    -o-appearance: none;
    appearance: none;
    background-color: #dddddd;
    height: 25px;
    width: 25px;
    display: inline-block;
    vertical-align: middle;
    border-radius: 50%;
    position: relative;
    cursor: pointer;
  }
  .form-wizard .wizard-form-radio input[type="radio"]:focus {
    outline: 0;
  }
  .form-wizard .wizard-form-radio input[type="radio"]:checked {
    background-color: #fb1647;
  }
  .form-wizard .wizard-form-radio input[type="radio"]:checked::before {
    content: "";
    position: absolute;
    width: 10px;
    height: 10px;
    display: inline-block;
    background-color: #ffffff;
    border-radius: 50%;
    left: 1px;
    right: 0;
    margin: 0 auto;
    top: 8px;
  }
  .form-wizard .wizard-form-radio input[type="radio"]:checked::after {
    content: "";
    display: inline-block;
    webkit-animation: click-radio-wave 0.65s;
    -moz-animation: click-radio-wave 0.65s;
    animation: click-radio-wave 0.65s;
    background: #000000;
    content: '';
    display: block;
    position: relative;
    z-index: 100;
    border-radius: 50%;
  }
  .form-wizard .wizard-form-radio input[type="radio"] ~ label {
    padding-left: 10px;
    cursor: pointer;
  }
  .form-wizard .form-wizard-header {
    text-align: center;
  }
  .form-wizard .form-wizard-next-btn, .form-wizard .form-wizard-previous-btn, .form-wizard .form-wizard-submit {
    background-color: #04c3e1;
    color: #ffffff;
    display: inline-block;
    min-width: 100px;
    min-width: 120px;
    padding: 10px;
    text-align: center;
  }
  .form-wizard .form-wizard-next-btn:hover, .form-wizard .form-wizard-next-btn:focus, .form-wizard .form-wizard-previous-btn:hover, .form-wizard .form-wizard-previous-btn:focus, .form-wizard .form-wizard-submit:hover, .form-wizard .form-wizard-submit:focus {
    color: #ffffff;
    opacity: 0.6;
    text-decoration: none;
  }
  .form-wizard .wizard-fieldset {
    display: none;
  }
  .form-wizard .wizard-fieldset.show {
    display: block;
  }
  .form-wizard .wizard-form-error {
    display: none;
    background-color: #d70b0b;
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 2px;
    width: 100%;
  }
  .form-wizard .form-wizard-previous-btn {
    background-color: #04c3e1;
  }
  .form-wizard .form-control {
    font-weight: 300;
    height: auto !important;
    padding: 15px;
    color: #888888;
    background-color: #f1f1f1;
    border: none;
  }
  .form-wizard .form-control:focus {
    box-shadow: none;
  }
  .form-wizard .form-group {
    position: relative;
    margin: 25px 0;
  }
  .form-wizard .wizard-form-text-label {
    position: absolute;
    left: 10px;
    top: 16px;
    transition: 0.2s linear all;
  }
  .form-wizard .focus-input .wizard-form-text-label {
    color: #888888;
    top: -18px;
    transition: 0.2s linear all;
    font-size: 12px;
  }
  .form-wizard .form-wizard-steps {
    margin: 30px 0;
  }
  .form-wizard .form-wizard-steps li {
    width: 25%;
    float: left;
    position: relative;
  }
  .form-wizard .form-wizard-steps li::after {
    background-color: #f3f3f3;
    content: "";
    height: 5px;
    left: 0;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    border-bottom: 1px solid #dddddd;
    border-top: 1px solid #dddddd;
  }
  .form-wizard .form-wizard-steps li span {
    background-color: #dddddd;
    border-radius: 50%;
    display: inline-block;
    height: 40px;
    line-height: 40px;
    position: relative;
    text-align: center;
    width: 40px;
    z-index: 1;
  }
  .form-wizard .form-wizard-steps li:last-child::after {
    width: 50%;
  }
  .form-wizard .form-wizard-steps li.active span, .form-wizard .form-wizard-steps li.activated span {
    background-color: #04c3e1;
    color: #ffffff;
  }
  .form-wizard .form-wizard-steps li.active::after, .form-wizard .form-wizard-steps li.activated::after {
    background-color: #04c3e1;
    left: 50%;
    width: 50%;
    border-color: #04c3e1;
  }
  .form-wizard .form-wizard-steps li.activated::after {
    width: 100%;
    border-color: #04c3e1;
  }
  .form-wizard .form-wizard-steps li:last-child::after {
    left: 0;
  }
  .form-wizard .wizard-password-eye {
    position: absolute;
    right: 32px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
  }
  @keyframes click-radio-wave {
    0% {
      width: 25px;
      height: 25px;
      opacity: 0.35;
      position: relative;
    }
    100% {
      width: 60px;
      height: 60px;
      margin-left: -15px;
      margin-top: -15px;
      opacity: 0.0;
    }
  }
  @media screen and (max-width: 767px) {
    .wizard-content-left {
      height: auto;
    }
  }
  
  canvas {
    height: 175px;
    border-style: solid;
    border-width: 1px;
    border-color: black;
  }

  input[type="file"] {
    display: block;
  }
  .imageThumb {
    min-height: 100px;
    border: 2px solid;
    padding: 1px;
    cursor: pointer;
    width: 100%;
    /* object-fit: contain !important; */
  }
  .pip {
    display: inline-block;
    margin: 10px 10px 0 0;
    width: 100%;
  }
  .remove {
    display: block;
    background: #444;
    border: 1px solid black;
    color: white;
    text-align: center;
    cursor: pointer;
  }
  .remove:hover {
    background: white;
    color: black;
  }
  .card{
    min-height: auto;
  }

  @media screen and (min-width: 767px) {
    .card{
      /* min-height: 450px; */
    }
    .radioCenter{
      position: absolute;
      padding-bottom: 15px;
      text-align: center !important;
    }
    .card ul{
      min-height: 300px
    }
  }

  .radioCenter{
    text-align: center !important;
  }

  
  </style>
</head>
<body style="background-color: #42bc00;color: #535b7c">
    <section class="wizard-section" style="padding-top: 125px;background-blend-mode: overlay;
    background-image: url(https://www.iconiccodedevelopment.com/wp-content/uploads/2020/11/geometric-bg-overlay-01.jpg),linear-gradient(180deg,#63bc32 0%,#42bc00 100%)!important;min-height:600px">
        <div class="row no-gutters">
            <div class="col-lg-8 col-md-10 offset-md-1 offset-lg-2">
                <div class="form-wizard">
                    <form role="form" method="POST" action="{{ route('companies.store') }}" id="FormSubmit" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-wizard-header">
                            <p>Fill all form field to go next step</p>
                            <ul class="list-unstyled form-wizard-steps clearfix">
                                <li class="active"><span>1</span></li>
                                <li><span>2</span></li>
                                <li><span>3</span></li>
                                <li><span>4</span></li>
                            </ul>
                        </div>
                        <div class="text-danger">
                            @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                            @endif
                        </div>
                        <div>@include('layouts.partials.alerts._alerts')</div>
                        <fieldset class="wizard-fieldset show" >
                            <h5 align="center">PLAN OPTIONS </h5>
                            <div class="row">
                                <div class="col-md-4">
                                  <div class="card">
                                    <div class="card-header Basic" align="center">
                                      Basic
                                    </div>
                                    <div class="card-body">
                                      <h1 align="center">R849</h1>
                                      <h5 align="center" class="pb-3">per month</h5>

                                      <ul>
                                      <li>All core functionality</li>
                                      <li>Free Subdomain to link to the platform*</li>
                                      <li>Pay as you go R15 per file-share credit</li>
                                      </ul>

                                      <!-- <p class="card-text" align="center">All core functionality</p>
                                      <p class="card-text" align="center">Free Subdomain to link to the platform</p>
                                      <p class="card-text" align="center">R15 per file-sharing credit</p> -->
                                      <div class="custom-control">
                                        <input type="hidden" class="custom-control-input" id="defaultGroupExample1" name="option" value=849 >
                                        {{-- <label class="custom-control-label" for="defaultGroupExample1">Basic</label> --}}
                                        <button class="btn basic-btn" style="color: #ffffff!important;
                                        border-width: 0px!important;
                                        border-radius: 26px;
                                        letter-spacing: 1px;
                                        font-size: 13px;
                                        font-family: 'Nunito Sans',Helvetica,Arial,Lucida,sans-serif!important;
                                        font-weight: 800!important;
                                        text-transform: uppercase!important;
                                        background-image: linear-gradient(
                                    91deg
                                    ,#53a0fe 0%,#2b87da 100%);width:100%" type="button">Basic</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="card">
                                    <div class="card-header Advanced" align="center">
                                    Advanced
                                    </div>
                                    <div class="card-body" >
                                      <h1 align="center">R1350</h1>
                                      <h5 align="center" class="pb-3">per month</h5>
                                      <ul>
                                      <li>All core functionality</li>
                                      <li>Get a free subdomain or the ability to link your custom domain to the platform*</li>
                                      <li>Pay as you go R15 per file-share credit</li>
                                      </ul>

                                      <div class="custom-control">
                                        {{-- <input type="hidden" class="custom-control-input" id="defaultGroupExample2" name="option" value=1350> --}}
                                        <button class="btn advanced-btn" style="color: #ffffff!important;
                                        border-width: 0px!important;
                                        border-radius: 26px;
                                        letter-spacing: 1px;
                                        font-size: 13px;
                                        font-family: 'Nunito Sans',Helvetica,Arial,Lucida,sans-serif!important;
                                        font-weight: 800!important;
                                        text-transform: uppercase!important;
                                        background-image: linear-gradient(
                                    91deg
                                    ,#52c419 0%,#31a500 100%);width:100%" type="button">Advanced</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="card">
                                    <div class="card-header Ultimate" align="center">
                                    Ultimate
                                    </div>
                                    <div class="card-body">
                                      <h1 align="center">R2399</h1>
                                      <h5 align="center" class="pb-3">per month</h5>
                                      <ul>
                                      <li>All core functionality</li>
                                      <li>Get a free subdomain*</li>
                                      <li>Optional Landing Page*</li>
                                      <li>The ability to link your custom domain to the platform*</li>
                                      <li>Unlimited file share credits</li>
                                      </ul>

                                      <div class="custom-control" >
                                        <input type="hidden" class="btn btn-info" id="defaultGroupExample3" name="option" value=2399>
                                        <!-- <label class="custom-control-label btn" for="defaultGroupExample3">Ultimate</label> -->
                                      <button class="btn ultimate-btn" style="color: #ffffff!important;
                                      border-width: 0px!important;
                                      border-radius: 26px;
                                      letter-spacing: 1px;
                                      font-size: 13px;
                                      font-family: 'Nunito Sans',Helvetica,Arial,Lucida,sans-serif!important;
                                      font-weight: 800!important;
                                      text-transform: uppercase!important;
                                      background-image: linear-gradient(
                                  91deg
                                  ,#8e8e8e 0%,#212121 100%);width:100%" type="button">Ultimate</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            
                            <div class="form-group clearfix">
                                <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                            </div>
                        </fieldset>	
                        <fieldset class="wizard-fieldset">
                            <h5 align="center">ACCOUNT INFORMATION</h5>
                            <div class="form-group">
                                <input type="text" class="form-control wizard-required" id="first_name" name="first_name" value="{{ old('first_name') }}" >
                                <label for="email" class="wizard-form-text-label">First name <span class="text-danger">*</span></label>
                                <div class="wizard-form-error text-danger validate_first_name">The first name field is required</div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control wizard-required" id="last_name" name="last_name" value="{{ old('last_name') }}" >
                                <label for="email" class="wizard-form-text-label">Last Name<span class="text-danger">*</span></label>
                                <div class="wizard-form-error text-danger validate_last_name">The last name field is required</div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control wizard-required" id="email" name="email" value="{{ old('email') }}" >
                                <label for="email" class="wizard-form-text-label">Email<span class="text-danger">*</span></label>
                                <div class="wizard-form-error text-danger validate_email">The email field is required</div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control wizard-required" id="pwd" name="password" value="{{ old('password') }}" onKeyUp="checkPasswordStrength()">
                                <label for="pwd" class="wizard-form-text-label">Password<span class="text-danger">*</span></label>
                                <div class="wizard-form-error text-danger validate_password">The password field is required</div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control wizard-required" id="cpwd" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                <label for="cpwd" class="wizard-form-text-label">Confirm Password<span class="text-danger">*</span></label>
                                <div class="wizard-form-error text-danger validate_password_confirmation">The password confirmation is required</div>
                            </div>
                            <div class="form-group clearfix">
                                <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                                <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                            </div>
                        </fieldset>	
                        <fieldset class="wizard-fieldset">
                            <h5 align="center">COMPANY INFORMATION</h5>
                            <div class="form-group">
                                <input type="text" class="form-control wizard-required" id="bname" name="company_name" value="{{ old('company_name') }}">
                                <label for="bname" class="wizard-form-text-label">Company Name<span class="text-danger">*</span></label>
                                <div class="wizard-form-error text-danger validate_company_name">The company name is required</div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control wizard-required" id="domain_name" name="domain_name" value="{{ old('domain_name') }}">
                                <label for="brname" class="wizard-form-text-label">Domain Name<span class="text-danger">*</span> <span class="d_name">(youname).iconiccodedevelopment.com</span></label>
                                <div class="wizard-form-error text-danger validate_domain_name">The domain name is required</div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                  <input type="radio" id="domain_sub" class="d_type" name="domain_type" value="1" checked> Free Subdomain to link to the platform
                                </div>
                                <div class="col-md-4">
                                  <input type="radio"  id="domain_already" class="d_type" name="domain_type" value="2"> Link your custom domain to the platform (Already have domain registered somewhere)
                                </div>
                                <div class="col-md-4">
                                  <input type="radio"  id="domain_new" class="d_type" name="domain_type" value="3"> Link your custom domain to the platform (assistance with new domain)
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control wizard-required" id="company_phone" name="company_phone" value="{{ old('company_phone') }}">
                                <label for="brname" class="wizard-form-text-label">Company phone<span class="text-danger">*</span></label>
                                <div class="wizard-form-error text-danger validate_company_phone">The company phone is required</div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control wizard-required" id="company_email" name="company_email" value="{{ old('company_email') }}">
                                <label for="brname" class="wizard-form-text-label">Company email<span class="text-danger">*</span></label>
                                <div class="wizard-form-error text-danger validate_company_email">The company email is required</div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control wizard-required" id="address1" name="address1" value="{{ old('address1') }}">
                                <label for="acname" class="wizard-form-text-label">Address <span class="text-danger">*</span></label>
                                <div class="wizard-form-error text-danger validate_address1">The address1 is required</div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control wizard-required" id="address2" name="address2" value="{{ old('address2') }}">
                                <label for="acon" class="wizard-form-text-label">Address 2<span class="text-danger">*</span></label>
                                <div class="wizard-form-error text-danger validate_address2">The address2 is required</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control wizard-required" id="zipcode" name="zipcode" value="{{ old('zipcode') }}">
                                        <label for="acon" class="wizard-form-text-label">Zip code<span class="text-danger">*</span></label>
                                        <div class="wizard-form-error text-danger validate_zipcode">The code is required</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control wizard-required" id="city" name="city" value="{{ old('city') }}">
                                        <label for="acon" class="wizard-form-text-label">City<span class="text-danger">*</span></label>
                                        <div class="wizard-form-error text-danger validate_city">The city is required</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                      <select class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }} wizard-required" required="required" id="country" name="country">
                                        <option value="">Choose country</option>
                                        @foreach(countries() as $country)
                                        <option value="{{ $country }}">{{ $country}}</option>
                                        @endforeach
                                        </select>
                                        {{-- <input type="text" class="form-control wizard-required" id="country" name="country" value="{{ old('country') }}"> --}}
                                        <label for="acon" class="wizard-form-text-label">Country<span class="text-danger">*</span></label>
                                        <div class="wizard-form-error text-danger validate_country">The country is required</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                              {{--  <label for="acon" class="wizard-form-text-label">Logo*</label>  --}}
                                <div class="field" align="left">
                                    <div class="row">
                                        <div class="col-md-4 col-12 dip">
                                            Logo*
                                        </div>
                                        <div class="col-md-8 col-12">
                                            <input type="file" id="logo" name="logo" class="form-control wizard-required"/>
                                            <div class="wizard-form-error text-danger validate_logo">The logo is required</div>
                                        </div>
                                    </div>
                                  </div>
                            </div>
                            <div class="form-group clearfix">
                                <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                                <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                            </div>
                        </fieldset>	
                        <fieldset class="wizard-fieldset">
                            <h5 align="center">An email will be send with the registration details. Proceed with payment option by clicking on the "Submit" button.</h5>
                          
                            <div class="form-group clearfix">
                                <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                                <a href="javascript:;" class="form-wizard-submit float-right">Submit</a>
                            </div>
                        </fieldset>	
                    </form>
                </div>
            </div>
        </div>
    </section>

</body>
</html>


<script type="text/javascript">
 
            jQuery('.ultimate-btn').click(function() {
              // jQuery(".d_name").hide();
              jQuery("#domain_sub").prop('disabled', false);
              jQuery("#domain_already").prop('disabled', false);
              jQuery("#domain_new").prop('disabled', false);
              jQuery("#defaultGroupExample3").val(2399);
              // jQuery("#defaultGroupExample1").attr('checked', false);
              // jQuery("#defaultGroupExample2").attr('checked', false);
              jQuery(".Ultimate").css("background-image", "linear-gradient(91deg,#8e8e8e 0%,#212121 100%)");
              jQuery(".Advanced").css("background-image", "linear-gradient(91deg,rgba(0, 0, 0, 0.03) 0%,rgba(0, 0, 0, 0.03) 100%)");
              jQuery(".Basic").css("background-image", "linear-gradient(91deg,rgba(0, 0, 0, 0.03) 0%,rgba(0, 0, 0, 0.03) 100%)");
              
            });            
            jQuery('.advanced-btn').click(function() {
              // jQuery(".d_name").hide();
              jQuery("#domain_sub").prop('disabled', false);
              jQuery("#domain_already").prop('disabled', false);
              jQuery("#domain_new").prop('disabled', false);
              jQuery("#defaultGroupExample3").val(1350);
              // jQuery("#defaultGroupExample2").prop('checked', true);
              // jQuery("#defaultGroupExample1").prop('checked', false);
              // jQuery("#defaultGroupExample3").prop('checked', false);
              jQuery(".Advanced").css("background-image", "linear-gradient(91deg,#52c419 0%,#31a500 100%)");
              jQuery(".Ultimate").css("background-image", "linear-gradient(91deg,rgba(0, 0, 0, 0.03) 0%,rgba(0, 0, 0, 0.03) 100%)");
              jQuery(".Basic").css("background-image", "linear-gradient(91deg,rgba(0, 0, 0, 0.03) 0%,rgba(0, 0, 0, 0.03) 100%)");
            });
            jQuery('.basic-btn').click(function() {
              jQuery(".d_name").show();
              jQuery("#domain_sub").prop('checked', true);
              jQuery("#domain_sub").prop('disabled', true);
              jQuery("#domain_already").prop('disabled', true);
              jQuery("#domain_new").prop('disabled', true);
              jQuery("#domain_already").attr('checked', false);
              jQuery("#domain_new").attr('checked', false);
              jQuery("#defaultGroupExample3").val(849);
              // jQuery("#defaultGroupExample1").attr('checked', true);
              // jQuery("#defaultGroupExample2").attr('checked', false);
              // jQuery("#defaultGroupExample3").attr('checked', false);
              jQuery(".Basic").css("background-image", "linear-gradient(91deg,#53a0fe 0%,#2b87da 100%)");
              jQuery(".Ultimate").css("background-image", "linear-gradient(91deg,rgba(0, 0, 0, 0.03) 0%,rgba(0, 0, 0, 0.03) 100%)");
              jQuery(".Advanced").css("background-image", "linear-gradient(91deg,rgba(0, 0, 0, 0.03) 0%,rgba(0, 0, 0, 0.03) 100%)");
            });
              jQuery('.form-wizard-next-btn').click(function() {
                var parentFieldset = jQuery(this).parents('.wizard-fieldset');
                var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
                var next = jQuery(this);
                var nextWizardStep = true;
                parentFieldset.find('.wizard-required').each(function(){
                    var thisValue = jQuery(this).val();
        
                    if( thisValue == "") {
                        jQuery(this).siblings(".wizard-form-error").slideDown();
                        if($(".show").length){
                          var nameArray = jQuery(this).attr("name").split('_');
                          var inputName = nameArray[0];

                          if(nameArray.length > 1){
                            inputName = nameArray[0] + ' ' + nameArray[1];
                          }

                          jQuery('.validate_'+ jQuery(this).attr("name")).empty();
                          jQuery('.validate_'+ jQuery(this).attr("name")).append('The '+ inputName +' field is required');

                        }
                        nextWizardStep = false;
                        
                    }
                    else {
                      jQuery(this).siblings(".wizard-form-error").slideUp();
                    }
                });
                if($(".show").length){
                  if(jQuery('#email').val()){
                    if(IsEmail(jQuery('#email').val()) == false){
                      jQuery('.validate_email').slideDown();
                      jQuery('.validate_email').empty();
                      jQuery('.validate_email').append('The email is invalid');
                      nextWizardStep = false;
                    }
                  }
                }

                if($(".show").length){
                  if(jQuery('#company_email').val()){
                    if(IsEmail(jQuery('#company_email').val()) == false){
                      jQuery('.validate_company_email').slideDown();
                      jQuery('.validate_company_email').empty();
                      jQuery('.validate_company_email').append('The company email is invalid');
                      nextWizardStep = false;
                    }
                  }
                }
                if($(".show").length){
                  if($('#zipcode').val() != "") {
                    var value = $('#zipcode').val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
                    var intRegex = /^\d+$/;
                    if(!intRegex.test(value)) {
                      jQuery('.validate_zipcode').slideDown();
                      jQuery('.validate_zipcode').empty();
                      jQuery('.validate_zipcode').append('The zipcode is invalid');
                      nextWizardStep = false;
                    }
                }
                }

                if($(".show").length){
                    if(jQuery('#pwd').val() && jQuery('#cpwd').val()){
                      if(jQuery('#pwd').val() !== jQuery('#cpwd').val()){
                        jQuery('.validate_password_confirmation').slideDown();
                        jQuery('.validate_password_confirmation').empty();
                        jQuery('.validate_password_confirmation').append('The password confirmation does not match');
                        nextWizardStep = false;
                      }
                  }
                }

                if( nextWizardStep) {
                    next.parents('.wizard-fieldset').removeClass("show","400");
                    currentActiveStep.removeClass('active').addClass('activated').next().addClass('active',"400");
                    next.parents('.wizard-fieldset').next('.wizard-fieldset').addClass("show","400");
                    jQuery(document).find('.wizard-fieldset').each(function(){
                        if(jQuery(this).hasClass('show')){
                            var formAtrr = jQuery(this).attr('data-tab-content');
                            jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function(){
                                if(jQuery(this).attr('data-attr') == formAtrr){
                                    jQuery(this).addClass('active');
                                    var innerWidth = jQuery(this).innerWidth();
                                    var position = jQuery(this).position();
                                    jQuery(document).find('.form-wizard-step-move').css({"left": position.left, "width": innerWidth});
                                }else{
                                    jQuery(this).removeClass('active');
                                }
                            });
                        }
                    });
                }
            });
            //click on previous button
            jQuery('.form-wizard-previous-btn').click(function() {
                var counter = parseInt(jQuery(".wizard-counter").text());;
                var prev =jQuery(this);
                var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
                prev.parents('.wizard-fieldset').removeClass("show","400");
                prev.parents('.wizard-fieldset').prev('.wizard-fieldset').addClass("show","400");
                currentActiveStep.removeClass('active').prev().removeClass('activated').addClass('active',"400");
                jQuery(document).find('.wizard-fieldset').each(function(){
                    if(jQuery(this).hasClass('show')){
                        var formAtrr = jQuery(this).attr('data-tab-content');
                        jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function(){
                            if(jQuery(this).attr('data-attr') == formAtrr){
                                jQuery(this).addClass('active');
                                var innerWidth = jQuery(this).innerWidth();
                                var position = jQuery(this).position();
                                jQuery(document).find('.form-wizard-step-move').css({"left": position.left, "width": innerWidth});
                            }else{
                                jQuery(this).removeClass('active');
                            }
                        });
                    }
                });
            });


            //click on form submit button
            jQuery(document).on("change",".d_type" , function(){
              var d_type = $("input[name='domain_type']:checked").val();
              // alert($("input[name='domain_type']:checked").val());
              if(d_type == 1){
                jQuery(".d_name").show();
              }
              if(d_type == 2){
                jQuery(".d_name").hide();
              }
              if(d_type == 3){
                jQuery(".d_name").hide();
              }
            });
            jQuery(document).on("click",".form-wizard .form-wizard-submit" , function(){
                var count = 0;
                var parentFieldset = jQuery(this).parents('.wizard-fieldset');
                var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
                parentFieldset.find('.wizard-required').each(function() {
                    var thisValue = jQuery(this).val();
                    if( thisValue == "" ) {
                        count = 1;
                        jQuery(this).siblings(".wizard-form-error").slideDown();
                    }
                    else {
                        jQuery(this).siblings(".wizard-form-error").slideUp();
                    }
                });
                if(count == 0){
                    $("#FormSubmit").submit();
                }
            });
            // focus on input field check empty or not
            jQuery(".form-control").on('focus', function(){
                var tmpThis = jQuery(this).val();
                if(tmpThis == '' ) {
                    jQuery(this).parent().addClass("focus-input");
                }
                else if(tmpThis !='' ){
                    jQuery(this).parent().addClass("focus-input");
                }
            }).on('blur', function(){
                var tmpThis = jQuery(this).val();
                if(tmpThis == '' ) {
                    jQuery(this).parent().removeClass("focus-input");
                    jQuery(this).siblings('.wizard-form-error').slideDown("3000");
                }
                else if(tmpThis !='' ){
                    jQuery(this).parent().addClass("focus-input");
                    jQuery(this).siblings('.wizard-form-error').slideUp("3000");
                }
            });


      $(document).ready(function() {
        jQuery(".d_name").show();
        jQuery(".Ultimate").css("background-image", "linear-gradient(91deg,#8e8e8e 0%,#212121 100%)");
        if (window.File && window.FileList && window.FileReader) {
          $("#logo").on("change", function(e) {
            var files = e.target.files,
              filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
              var f = files[0]
              var fileReader = new FileReader();
              fileReader.onload = (function(e) {
                var file = e.target;
                $('.dip').empty();

                  $('.dip').append("<span class=\"pip1\">" +
                    "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                    "<br/><span class=\"remove\">Remove image</span>" +
                    "</span>");

                $(".remove").click(function(){
                  $(this).parent(".pip1").remove();
                  $('.dip').append("Logo*");
                  $('#logo').val('');
                });
                
                // Old code here
                /*$("<img></img>", {
                  class: "imageThumb",
                  src: e.target.result,
                  title: file.name + " | Click to remove"
                }).insertAfter("#files").click(function(){$(this).remove();});*/
                
              });
              fileReader.readAsDataURL(f);
            }
          });
        } else {
          alert("Your browser doesn't support to File API")
        }
      });


      function IsEmail(email) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(email);
      }

      function checkPasswordStrength() {
        var number = /([0-9])/;
        var alphabets = /([a-zA-Z])/;
        var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
        if($('#pwd').val().length<6) {
          // console.log($('#pwd').val().length);
          jQuery('.validate_password').slideDown();
          jQuery('.validate_password').empty();
          jQuery('.validate_password').append('Weak (should be atleast 6 characters.)');
          nextWizardStep = false;
        } else { 

        if($('#pwd').val().match(number) && $('#pwd').val().match(alphabets) && $('#pwd').val().match(special_characters)) { 
          {{--  jQuery('.validate_password').slideDown();  --}}
          jQuery('.validate_password').empty();
          jQuery('.validate_password').append('Strong');
          jQuery('.validate_password').slideUp();
        } else {
          jQuery('.validate_password').slideDown();
          jQuery('.validate_password').empty();
          jQuery('.validate_password').append('Medium (should include alphabets, numbers and special characters.');
          nextWizardStep = false;
        }}}
      
</script>