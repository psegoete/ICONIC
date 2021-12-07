

@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item active'>Transactions for {{ $customer->name }} </li>
@endsection

@section('content')
<div class="clearfix">
    <div class="row">
        <div class="col-md-8">
            <div class="clearfix">
                <div class="col-lg">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Transactions {{ $customer->name }}             
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered data-table " style="width:100%">
                                        <thead class="thead-light">
                                        <tr id="">
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Credits</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <strong>Add transaction</strong> 
                    <span class="center"> </span>
                </div>
                {{--  <div class="container">  --}}

                    <div class="card-body">
                        <form method="POST" action="{{ route('transactions.store') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} ">
                                <label class="col-form-label" for="description">Description</label>
                                    <input type="text" id="description" name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }} " required
                                        value="{{ old('description') }}">
            
                                        @if ($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                            </div>

                            <input type="hidden" name="user_id" value="{{ $id }}">
    
                            <div class="form-group{{ $errors->has('credits') ? ' has-error' : '' }} ">
                                <label class="col-form-label" for="credits">Credits</label>
                                    <input type="text" id="credits" name="credits" class="form-control{{ $errors->has('credits') ? ' is-invalid' : '' }} "
                                        required
                                        value="{{ old('credits') }}">
            
                                        @if ($errors->has('credits'))
                                            <span class="text-danger">{{ $errors->first('credits') }}</span>
                                        @endif
                            </div>
    
                            <div class="form-group{{ $errors->has('action') ? ' has-error' : '' }} ">
                                <label class="col-form-label" for="action">Add or Minus</label>
                                   <select class="form-control{{ $errors->has('action') ? ' is-invalid' : '' }} " required id="action" name="action">
                                            <option value="">Select an option</option>
                                            <option value="add">Add(+)</option>
                                            <option value="minus">Minus(-)</option>
                                        </select>
            
                                        @if ($errors->has('action'))
                                            <span class="text-danger">{{ $errors->first('action') }}</span>
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

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
        
        var table = $('.data-table').DataTable({
        processing: true,
        {{-- serverSide: true, --}}
        responsive: true,
        ajax: "{{ route('transactions.show',$id) }}",
        columns: [
        {data: 'created_at', name: 'created_at'},
        {data: 'status', name: 'status'},
        {data: 'credits', name: 'credits'},
        {data: 'description', name: 'description'},
        ]
        });
        
        });
        
        </script>
@stop