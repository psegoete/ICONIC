@extends('admin.layouts.default')

@section('content')
<div class="row">
    @if(auth()->user()->role == 'super-admin')
    <div class="col-12">
    <iframe
      src="{{ asset('assets/videos/Iconic-Code-Superadmin.mp4') }}"
      allowfullscreen
      allowtransparency
      width="100%" height="350px"></iframe>
    </div>
    @endif
    @if(auth()->user()->role == 'admin')
    <div class="col-12">
    <iframe
      src="{{ asset('assets/videos/Admin.mp4') }}"
      allowfullscreen
      allowtransparency
      width="100%" height="350px"></iframe>
    </div>
    @endif
    @if(auth()->user()->role == 'customer')
    <div class="col-12">
    <iframe
      src="{{ asset('assets/videos/Customer.mp4') }}"
      allowfullscreen
      allowtransparency
      width="100%" height="350px"></iframe>
    </div>
    @endif
</div>
@endsection 