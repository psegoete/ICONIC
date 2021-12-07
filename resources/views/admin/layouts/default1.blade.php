@extends('layouts.admin.master1')

@section('breadcrumb')
    @yield('admin.breadcrumb')
@endsection

@include('admin.layouts.partials._sidebar')

@section('content')
    @yield('admin.stats')

    @include('layouts.partials.alerts._alerts')

    @yield('admin.content')
@endsection