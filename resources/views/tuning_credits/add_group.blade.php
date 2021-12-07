@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('tuning-credits.index') }}">Tuning credits</a>
</li>
<li class='breadcrumb-item active'>Add credit group</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong>Add credit group</strong> 
                    <span class="center"> </span>
                </div>
                <div class="card-body">
                    <form action="{{ url('add-group') }}" method="POST" class="form-horizonal">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="name">Group name</label>
                                    <input type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} "
                                        placeholder="Enter group name" required
                                        value="{{ old('name') }}">
            
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                            </div>
                            @foreach($credit_tiers as $key => $credit_tier)
                                <div class="form-group {{ $errors->has('tier_from_'.$credit_tier->id) ? ' has-error' : '' }} row">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="{{'tier_from_'.$credit_tier->id}}">@if($credit_tier->amount > 1) {{$credit_tier->amount}} credits @else {{$credit_tier->amount}} credit @endif from</label>
                                            <input type="text" id="{{'tier_from_'.$credit_tier->id}}" name="tier_from_{{$credit_tier->id}}" class="form-control{{ $errors->has('tier_from_'.$credit_tier->id) ? ' is-invalid' : '' }} " required
                                                value="{{ old('tier_from_'.$credit_tier->id) }}">
                    
                                                @if ($errors->has('tier_from_'.$credit_tier->id))
                                                    <span class="text-danger">{{ $errors->first('tier_from_'.$credit_tier->id) }}</span>
                                                @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="tier_for_{{$credit_tier->id}}">@if($credit_tier->amount > 1) {{$credit_tier->amount}} credits @else {{$credit_tier->amount}} credit @endif for</label>
                                            <input type="text" id="tier_for_{{$credit_tier->id}}" name="tier_for_{{$credit_tier->id}}" class="form-control{{ $errors->has('tier_for_'.$credit_tier->id) ? ' is-invalid' : '' }} " required
                                                value="{{ old('tier_for_'.$credit_tier->id) }}">
                    
                                                @if ($errors->has('tier_for_'.$credit_tier->id))
                                                    <span class="text-danger">{{ $errors->first('tier_for_'.$credit_tier->id) }}</span>
                                                @endif
                                    </div>
                                </div>

                            @endforeach
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Save
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection