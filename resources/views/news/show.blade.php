@extends('admin.layouts.default')

@section('admin.breadcrumb')
{{-- <li class="breadcrumb-item">
    <a href="{{ route('news.index') }}">{{ $news->title }}</a>
</li> --}}
<li class='breadcrumb-item active'>{{ $news->title }}</li>
@endsection


@section('admin.content')
<div class="row">
    <div class="col-md-6">
        <h1>{{ $news->title }}</h1>
    <div class="clearfix">
        <div class="card">
            <div class="card-header">
                <strong>{{ Carbon\Carbon::parse($news->display_date)->format('d M yy') }}</strong> 
                <span class="center"> </span>
            </div>
            <div class="card-body">
                {!! $news->contents !!}
            </div>
        </div>
    </div>
</div>
</div>
@endsection