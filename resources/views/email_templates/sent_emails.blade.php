
@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class='breadcrumb-item '>Sent mails </li>
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Sent mails              
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100px">
                            <thead class="thead-light">
                            <tr id="">
                            <th>From</th>
                            <th>Recipients</th>
                            <th>Subject</th>
                            <th>Updated At</th>
                            <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($mails as $key => $mail)
                                <tr>
                                    <td>
                                        {{  $company->company_email }}
                                    </td>
                                    <td>
                                        {{  \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->email }}
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
                                                <a href="" class='btn btn-info' data-toggle="modal" data-target="#myEditModal{{ $mail->id }}" title='Edit your file service'><i class='fa fa-btn fa-edit'></i> </a>
                                            </div>
                                            <div class="pr-1 pl-1 pt-1 pb-1">
                                                <a href="{{url('resend/'.$mail->id)}}" class='btn btn-info' data-id='full->id' title='Download the original file for this file service'><i class="fa fa-paper-plane"></i> </a>
                                            </div>

                                        </nav>
                                    </td>
                                    @include('email_templates._modal')
                                </tr>
                                
                                @endforeach
                            </tbody>
                            </table>
                            <div class="row">
                                <div class="col-12 flex-wrap">
                                    <div class="float-right" >
                                        {{ $mails->links() }}
                                    </div>
                                </div>
                             
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')

<script type="text/javascript">

    
    {{--  $(document).ready(function () {
        $('.data-table').DataTable({processing: true,responsive: true, "order": [],"aaSorting": []});
    });  --}}
    </script>
@stop