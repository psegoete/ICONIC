@extends('account.layouts.default')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 offset-sm-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create new project</h4>

                        <form method="POST" action="{{ route('chats.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                <label for="message" class="control-label">Message</label>

                                <input id="message" type="text"
                                       class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}"
                                       name="message"
                                       value="{{ old('message') }}"  autofocus>

                                @if ($errors->has('message'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('filename') ? ' has-error' : '' }}">
                                <label for="filename" class="control-label">File Name</label>

                                <input id="filename" type="text"
                                       class="form-control{{ $errors->has('filename') ? ' is-invalid' : '' }}"
                                       name="filename"
                                       value="{{ old('filename') }}"  autofocus>

                                @if ($errors->has('filename'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('filename') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
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