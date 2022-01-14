{{--  @extends('account.layouts.default')  --}}
@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class="breadcrumb-item">
        <a href="{{ route('file_services.index') }}">File services</a>
    </li>
<li class='breadcrumb-item '>{{ $file_service->model }}  {{ $file_service->make }}  {{ $file_service->engine }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                    <span class="title"><i class="fas fa-comment-dots"></i> File service information</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>No.</strong>
                        <p>{{ $file_service->id }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Created At</strong>
                        <p>{{ $file_service->created_at }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Status</strong>
                        <p>{{ $file_service->status }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Credits</strong>
                        <p>{{ $file_service->credits }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Tuning types</strong>
                        <p>{{ $file_service->tuning_type }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tuning options</strong>
                        <p>{{ $file_service->tuning_options }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Timeframe</strong>
                        <p>{{ $file_service->timeframe }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>On Dynos?</strong>
                        <p>{{ $file_service->dyno }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Info</strong>
                        <p>{{ $file_service->timefinforrame }}</p>
                    </div>
                </div>
                <div class="row">
                    @if ($file_service->modified)
                        <div class="col-md-6">
                            <strong>Modified file</strong>
                            <p>
                                <a class="nav-item nav-link" href="{{ URL::to('download_modified/' . $file_service->id) }}" title="Download the modified file for this file service">
                                    <i class="fa fa-file"></i>
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                    <span class="title"><i class="fas fa-comment-dots"></i> Car information</span>
            </div>
            <div class="card-body">
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
                        <strong>Engine HP</strong>
                        <p>{{ $file_service->engine_hp }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Year</strong>
                        <p>{{ $file_service->year }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Gearbox</strong>
                        <p>{{ $file_service->gearbox }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Read method</strong>
                        <p>{{ $file_service->read_method }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>VIN</strong>
                        <p>{{ $file_service->vin }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection