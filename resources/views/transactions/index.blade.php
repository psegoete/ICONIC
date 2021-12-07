

@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item active'>Transactions</li>
@endsection

@section('content')
{{--  <div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Transactions                
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <form method="get" action="{{ route('transactions.index') }}" class="form-inline float-right">
                            {{ csrf_field() }}
                                    <div class="form-group mb-2">
                                        <input type="text" placeholder="Search.." name="search" class="form-control">
                                
                                    </div>
    
                                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i></button>
                        
                        </form>
                    </div>
                    
                </div>
                    
                <table class="table table-responsive-sm table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Credits</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-yy')}}</td>
                            <td>{{ $transaction->status }}</td>
                            <td>{{ $transaction->credits }}</td>
                            <td>{{ $transaction->description }}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                    
                    
                </table>
                <div class="row">
                    <div class="col-12">
                        <div class="float-right" >
                            {{ $transactions->links() }}
                        </div>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
</div>  --}}

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Transactions               
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
@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
        
        var table = $('.data-table').DataTable({
        processing: true,
        {{-- serverSide: true, --}}
        responsive: true,
        ajax: "{{ route('transactions.index') }}",
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