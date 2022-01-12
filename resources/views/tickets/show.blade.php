@extends('admin.layouts.default2')
@section('title', $ticket->title)
@section('admin.breadcrumb')
<li class="breadcrumb-item">
        <a href="{{ route('tickets.index') }}">Tickets</a>
    </li>
<li class='breadcrumb-item '>  @if(CreatyDev\Domain\Ticket\Models\Category::where('id', $ticket->category_id)->firstOrFail()->name == 'File service')
    File service - {{ $ticket->subject }}
@else
   General question - {{ $ticket->subject }}
@endif
</li>
@endsection
@section('content')
<div class="clearfix">
    {{-- @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
     --}}
    <div class="row">
        <div class="col-md-6">
            
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <span class="title">
                        Support conversation
                    </span>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            @include('tickets.comments')
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            @include('tickets.reply')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(CreatyDev\Domain\Ticket\Models\Category::where('id', $ticket->category_id)->firstOrFail()->name == 'File service')
            <div class="col-md-6">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <span class="title"><i class="fas fa-ticket-alt"></i>File service information</span>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>No.</strong>
                                <p>{{ $file_service->id }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Tuner</strong>
                                <p>{{ $tunner->first_name }} {{ $tunner->last_name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Car</strong>
                                <p>{{ $file_service->model }}  {{ $file_service->make }}  {{ $file_service->engine }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>ECU</strong>
                                <p>{{ $file_service->ecu }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Date submitted</strong>
                                <p>{{ $file_service->created_at }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Tuning type</strong>
                                <p>{{ $tuning_type->label }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Tuning options</strong>
                                @foreach($tuning_options as $tuning_option)
                                    <div>{{ $tuning_option->label }}</div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Gearbox</strong>
                                <p>{{ $gearbox->gbName }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Read method</strong>
                                <p>{{ $readmethod->read_method_name }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>License plate</strong>
                                <p>{{ $file_service->license_plate }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>VIN</strong>
                                <p>{{ $file_service->vin }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Fuel octane rating</strong>
                                <p>{{ $file_service->fuel_octane_rating }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Info</strong>
                                <p>{{ $file_service->info }}</p>
                            </div>
                        </div>
                        <div class="row">
                            @if(Auth::user()->role == 'admin')
                                <div class="col-md-6">
                                    <strong>Original file</strong>
                                    <p>
                                        <a class="" href="{{ URL::to('files/' . $file_service->id) }}" title="Download the original file">Download
                                        </a>
                                    </p>
                                </div> 
                            @endif
                            @if($file_service->modified)
                                <div class="col-md-6">
                                    <strong>Modified file</strong>
                                    <p>
                                        <a class="" href="{{ URL::to('download_modified/' . $file_service->id) }}" title="Download the modified file ">Download
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>   
                        
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection