@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'> Tuning credit prices</li>
@endsection

@section('content')
<div class="row">
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Tuning credits
                <div class="float-right">

                    <a href="{{ url('add-tier') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i> Add tier</a> 
                     <a href="{{ url('add-group') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i>  Add group</a> 
                </div>
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table1 " style="width:100%">
                            <thead class="thead-light">
                                <tr id="">
                                    <th>Group</th>
                                    @foreach($credit_tier_amounts as $key => $credit_tier_amount)
                                    <th>@if($credit_tier_amount->amount > 1) {{$credit_tier_amount->amount}} credits @else {{$credit_tier_amount->amount}} credit @endif
                                        <meta name='csrf-token' content='$csrf_token'> <a id='delete-credits-tier' data-id="{{$credit_tier_amount->id }}" data-name="{{$credit_tier_amount->amount }}" class='delete-credits-tier'>remove</a>
                                    </th>
                                    @endforeach
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($credit_groups as $key => $credit_group)
                                <tr>
                                    <td>
                                        {{\Illuminate\Support\Str::ucfirst($credit_group->name)}}
                                    </td>
                                    @foreach($credit_tier_amounts as $key => $credit_tier_amount)
                                    <td>R {{\CreatyDev\Domain\Credittier::where([['credit_group_id', '=', $credit_group->id],['credittier_amounts_id','=',$credit_tier_amount->id]])->first()->from }} -> R {{\CreatyDev\Domain\Credittier::where([['credit_group_id', '=', $credit_group->id],['credittier_amounts_id','=',$credit_tier_amount->id]])->first()->for }}</td>
                                    @endforeach
                                    <td>
                                        <nav class="nav" role="navigation" aria-label="Role options">
                                            <div class="pr-1 pl-1 pt-1 pb-1">
                                                <a href="{{ url('edit-group/'. $credit_group->id) }}" class='btn btn-info' data-id='full->id' title='Edit your credit group'><i class='fa fa-btn fa-edit'></i> </a>
                                            </div>
                                            <div class="pr-1 pl-1 pt-1 pb-1">
                                                @if($credit_group->default == 1)
                                                <a class='btn btn-danger delete-credits-group'><i class='fa fa-trash'></i></a>
                                                @else
                                                @if(deleteGroup($credit_group->id) > 0)
                                                <a class='btn btn-danger delete-credits-group'><i class='fa fa-trash'></i></a>
                                                @else
                                                <meta name='csrf-token' content='$csrf_token'> <a id='delete-credits-group' data-id="{{$credit_group->id}}" data-name="{{$credit_group->name}}" class='btn btn-danger delete-credits-group'><i class='fa fa-trash'></i></a>
                                                @endif
                                                @endif
                                            </div>
                                            <div class="pr-1 pl-1 pt-1 pb-1">
                                                @if($credit_group->default == 1)
                                                <a class='btn btn-success delete-credits-group'><i class='fa fa-check-circle'></i></a>
                                                @else
                                                <meta name='csrf-token' content='$csrf_token'> <a id='edit-credits-group-default' data-id="{{$credit_group->id}}" data-name="{{$credit_group->name}}" class='btn btn-success edit-credits-group-default' disabled><i class='fa fa-check-circle'></i></a>
                                                @endif
                                            </div>
                                        </nav>
                                    </td> 
                
                                </tr>
                                @endforeach
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
            $('.data-table1').DataTable({processing: true,responsive: true});
        var table = $('.data-table').DataTable({
        processing: true,
        {{-- serverSide: true, --}}
        responsive: true,
        ajax: "{{ route('tuning-credits.index') }}",
        columns: [
        {data: 'description', name: 'description'},
        {data: 'from', name: 'from'},
        {data: 'for', name: 'for'},
        {data: 'for', name: 'for', orderable: false, searchable: false},
        ],
        "columnDefs": [ 
            {
                "targets": 3,
                "data": "Action",
                "render": function (data, type, full, meta){
                    return "<a href="+document.URL+'/'+ full.id +'/edit'+" class='btn btn-success' data-id='full->id'><i class='fa fa-btn fa-edit'></i> </a> <meta name='csrf-token' content='$csrf_token'> <a id='delete-tuning-credits' data-id=" +full.id + " class='btn btn-danger delete-tuning-credits'><i class='fa fa-btn fa-trash'></i></a>";
                }
                },
                {
                "targets": 2,
                "data": "Action",
                "render": function (data, type, full, meta){
                    return "R " + data;
                }
                },
                {
                "targets": 1,
                "data": "Action",
                "render": function (data, type, full, meta){
                    return "R " + data;
                }
                },
                {
                "targets": 0,
                "data": "Action",
                "render": function (data, type, full, meta){
                    return data + ' credits';
                }
                }]
        });
        
        });

         $('body').on('click', '#delete-credits-tier', function () {
            var credit_tier_id = $(this).data("id");
            var credit_tier_name = $(this).data("name");
            if(credit_tier_name > 1){
                credit_tier_name = credit_tier_name + ' credits?';
            }else{
                credit_tier_name = credit_tier_name + ' credit?';
            }
            var token = $("meta[name='csrf-token']").attr("content");
            $.confirm({
                title: 'Are you sure?',
                content: 'Do you want to remove the price tier for '+credit_tier_name,
                buttons: {
                    no: function () {
                    
                    },
                    yes: {
                        text: 'yes',
                        btnClass: 'btn-red',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $.ajax({
                                type: "DELETE",
                                url: "/deletet-tier/"+credit_tier_id,
                                data: {
                                "id": credit_tier_id,
                                "_token": token,
                                },
                                success: function (data) {
                                    location.reload();
                                },
                                error: function (data) {
                                }
                                });
                        }
                    }
                }
            });
        });
        
         $('body').on('click', '#delete-credits-group', function () {
            var tuning_credit_id = $(this).data("id");
            var group = $(this).data("name");
            var token = $("meta[name='csrf-token']").attr("content");

            $.confirm({
                title: 'Are you sure?',
                content: "Do you want to remove the price group '"+group+"'?",
                buttons: {
                    no: function () {
                    
                    },
                    yes: {
                        text: 'yes',
                        btnClass: 'btn-red',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $.ajax({
                                type: "DELETE",
                                url: "/delete-group/"+tuning_credit_id,
                                data: {
                                "id": tuning_credit_id,
                                "_token": token,
                                },
                                success: function (data) {
                                    location.reload();
                                },
                                error: function (data) {
                                }
                                });
                        }
                    }
                }
            });
        });
         $('body').on('click', '#edit-credits-group-default', function () {
            var credit_group_id = $(this).data("id");
            var group = $(this).data("name");
            var token = $("meta[name='csrf-token']").attr("content");
            $.confirm({
                title: 'Are you sure?',
                content: "Do you want to make '"+ group +"' the new default price group?",
                buttons: {
                    no: function () {
                    
                    },
                    yes: {
                        text: 'yes',
                        btnClass: 'btn-green',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $.ajax({
                                type: "GET",
                                url: "/edit-group-default/"+credit_group_id,
                                success: function (data) {
                                    location.reload();
                                },
                                error: function (data) {
                                }
                                });
                        }
                    }
                }
            });
        });
        
    </script>
@stop