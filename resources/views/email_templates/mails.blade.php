
@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class='breadcrumb-item '>Mail templates</li>
@endsection
@section('content')

<div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Mail templates               
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%">
                            <thead class="thead-light">
                            <tr id="">
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Updated At</th>
                            <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($mails as $key => $mail)
                                <tr>
                                    <td>
                                        {{  $mail->name }}
                                    </td>
                                    <td>
                                        {{  $mail->subject }}
                                    </td>
                                    <td>
                                        {{  $mail->updated_at }}
                                    </td>
                                    <td>
                                        <nav class="nav" role="navigation" aria-label="Role options">
                                            <div class="pr-1 pl-1 pt-1 pb-1">
                                                <a href="{{ url('mail-templates/'. $mail->id) }}" class='btn btn-info' data-id='full->id' title='Edit your file service'><i class='fa fa-btn fa-edit'></i> </a>
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
        $('.data-table').DataTable({processing: true,responsive: true});

            $('body').on('click', '#delete-file_service', function () {
                var file_service_id = $(this).data("id");
                console.log(file_service_id);
                var token = $("meta[name='csrf-token']").attr("content");
                $.confirm({
                    title: 'Confirm!',
                    content: 'Are You sure want to delete!',
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
                                    url: "/file_services/"+file_service_id,
                                    data: {
                                    "id": file_service_id,
                                    "_token": token,
                                    },
                                    success: function (data) {
                                        location.reload(true);
                                    var table = $('.data-table').DataTable();
                            
                                    table.ajax.reload();           },
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