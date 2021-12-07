@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item active'>Customers</li>
@endsection
@section('content')
<div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Customers                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div>@include('layouts.partials.alerts._alerts')</div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%">
                            <thead class="thead-light">
                            <tr id="">
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>email</th>
                            <th>Updated Date</th>
                            <th>Created Date</th>
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
        ajax: "{{ url('tenants') }}",
        columns: [
        {data: 'first_name', name: 'first_name'},
        {data: 'last_name', name: 'last_name'},
        {data: 'email', name: 'email'},
        {data: 'updated_at', name: 'updated_at'},
        {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
        ]
        });
        
        });

        $('body').on('click', '#impersonate-customer', function () {
            var email = $(this).data("email");
            var token = $("meta[name='csrf-token']").attr("content");
            var x = confirm("Are You sure want to impersonate this customer!");

            if(x){
                $.ajax({
                    type: "POST",
                    url: "{{ route('users.impersonate.store')}}",
                    data: {
                    "email": email,
                    "_token": token,
                    },
                    success: function (data) {
                    window.location = '/';
                },
                    error: function (data) {
                    console.log('Error:', data);
                    }
                    });
            }else{
                
            }
            
            
            });
        
        </script>
@stop