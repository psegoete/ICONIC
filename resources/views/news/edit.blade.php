@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('news.index') }}">News</a>
</li>
<li class='breadcrumb-item active'>Create artitle</li>
@endsection


@section('admin.content')
<div class="row">
    <div class="col-md-6">
    <div class="clearfix">
        <div class="card">
            <div class="card-header">
                <strong>Create artitle</strong> 
                <span class="center"> </span>
            </div>
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="card-body">
                <form method="POST" action="{{ route('news.update', $news->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                        <div class="form-group{{ $errors->has('visibility') ? ' has-error' : '' }} ">

                            <label class="col-form-label" for="visibility">Visibility <span class="text-danger">*</span></label>
                                    <select class="form-control{{ $errors->has('visibility') ? ' is-invalid' : '' }} " required="required" id="visibility" name="visibility" >
                                        <option value="" selected="selected">Select a visibility</option>
                                        <option value="Visible" {{ $news->visibility  == 'Visible'? 'selected="selected"' : '' }}>Visible</option>
                                        <option value="Hidden" {{ $news->visibility  == 'Hidden'? 'selected="selected"' : '' }}>Hidden</option>
                                    </select>
        
                                    @if ($errors->has('visibility'))
                                        <span class="text-danger">{{ $errors->first('visibility') }}</span>
                                    @endif

                        </div>
                        
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="col-form-label" for="title">Article title <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }} "
                                    placeholder="Enter title" required
                                    value="{{ old('title', $news->title) }}">
        
                                    @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                        </div>

                        <div class="form-group{{ $errors->has('display_date') ? ' has-error' : '' }}">
                            <label class="col-form-label" for="contents">Display date <span class="text-danger">*</span></label>
                                <input type="date" id="display_date" name="display_date" class="form-control{{ $errors->has('display_date') ? ' is-invalid' : '' }} "
                                    placeholder="Enter name" required
                                    value="{{ old('display_date',\Carbon\Carbon::parse($news->display_date)->format('Y-m-d')) }}">
        
                                    @if ($errors->has('display_date'))
                                        <span class="text-danger">{{ $errors->first('display_date') }}</span>
                                    @endif
                        </div>

                        <div class="form-group{{ $errors->has('contents') ? ' has-error' : '' }}">
                            <label class="col-form-label" for="contents">Contents <span class="text-danger">*</span></label>
                                <textarea type="text" id="contents"  class="form-control{{ $errors->has('contents') ? ' is-invalid' : '' }} summernote" required
                                    name="contents">{{ old('contents', $news->contents) }}</textarea>
        
                                    @if ($errors->has('contents'))
                                        <span class="text-danger">{{ $errors->first('contents') }}</span>
                                    @endif
                        </div>
        
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