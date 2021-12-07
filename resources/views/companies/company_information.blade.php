@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class="breadcrumb-item">Company configuration</li>
@endsection
@section('content')
<div class="container">
  <ul class="nav nav-pills nav-fill navtop">
    <li class="nav-item">
        <a class="nav-link active" href="#menu1" data-toggle="tab">Company information</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#menu2" data-toggle="tab">Platform settings</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#menu3" data-toggle="tab">Availability</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#menu4" data-toggle="tab">Legal documents</a>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" role="tabpanel" id="menu1">
      @include('companies.company_information_tab')
    </div> 

    <div class="tab-pane" role="tabpanel" id="menu2">
      @include('companies.platform_settings')
    </div>

    <div class="tab-pane" role="tabpanel" id="menu3">
      @include('companies.availability')
    </div>

    <div class="tab-pane" role="tabpanel" id="menu4">
      @include('companies.legal_documents')
    </div>
  </div>
</div>
@endsection
                                                      