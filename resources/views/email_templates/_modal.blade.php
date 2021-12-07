<!-- New file service -->
@if($mail->email_type  == 'new_file_service')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#29363d">
            <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" style="background-color: #e4e5e6">
            <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                        <p style="margin-left: 6px;margin-top: 6%">
                            Hi there
                        </p>
                        <p style="margin-left: 6px">
                            A new <a href="{{ url('/file_services/'. $mail->file_service_id. '/edit') }}">file service</a> has been created.
                        </p>
                         <p style="margin-left: 6px">
                             <strong>
                                Customer:
                            </strong>
                         </p>
                        <p style="margin-left: 6px">
                            {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->name }}
                        </p>
                        <p style="margin-left: 6px">
                            <strong>
                                Car:
                            </strong>
                        </p>
                        <p style="margin-left: 6px">
                            {{ \CreatyDev\Domain\FileService::find($mail->file_service_id)->make.' '. \CreatyDev\Domain\FileService::find($mail->file_service_id)->model.' '.\CreatyDev\Domain\FileService::find($mail->file_service_id)->generation.' '.\CreatyDev\Domain\FileService::find($mail->file_service_id)->engine}}
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
            </div>
            @include('email_templates._social_media')
        </div>
        </div>
    </div>
</div>
@endif
@if($mail->email_type  == 'completed_file_service')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#29363d">
            <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" style="background-color: #e4e5e6">
            <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                        <p style="margin-left: 6px;margin-top: 6%">
                            Dear {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->title }} {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->last_name }}
                        </p>
                        <p style="margin-left: 6px">
                            Your file service for {{ \CreatyDev\Domain\FileService::find($mail->file_service_id)->make.' '. \CreatyDev\Domain\FileService::find($mail->file_service_id)->model.' '.\CreatyDev\Domain\FileService::find($mail->file_service_id)->generation.' '.\CreatyDev\Domain\FileService::find($mail->file_service_id)->engine}} {{ $company->company_name}}
                            <a href="{{ url('/file_services') }}">file service</a> is ready.
                            Log in to download your modified file.
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
            </div>
            @include('email_templates._social_media')
        </div>
        </div>
    </div>
</div>
@endif
@if($mail->email_type  == 'verifaication_account')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#29363d">
            <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" style="background-color: #e4e5e6">
            <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                        <p style="margin-left: 6px;margin-top: 6%">
                            Dear {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->title }} {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->last_name }}
                        </p>
                        <p style="margin-left: 6px">
                            Your account has being activated. You can now start using the system.
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
            </div>
            @include('email_templates._social_media')
        </div>
        </div>
    </div>
</div>
@endif

@if($mail->email_type  == 'close_support_ticket')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#29363d">
            <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" style="background-color: #e4e5e6">
            <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                        <p style="margin-left: 6px;margin-top: 6%">
                            Dear {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->title }} {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->last_name }}
                        </p>
                        <p style="margin-left: 6px">
                            Your ticket ({{ CreatyDev\Domain\Ticket\Models\Ticket::find($mail->ticket_id)->subject}}) on {{ $company->company_name}} has been closed.
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
            </div>
            @include('email_templates._social_media')
        </div>
        </div>
    </div>
</div>
@endif
@if($mail->email_type  == 'company_registration')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#29363d">
            <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" style="background-color: #e4e5e6">
            <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                        <p style="margin-left: 6px;margin-top: 6%">
                            Dear {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->title }} {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->last_name }}
                        </p>
                        <p style="margin-left: 6px">
                            You are receiving this email because we received a company registration request for your platform on <a href="http://register.iconiccodedevelopment.com">Iconic Code Development</a> .
                        </p>
                        <p style="margin-left: 6px; text-align: center">
                            <form method="get" action="{{'http://register.iconiccodedevelopment.com/companies/payment/'.$mail->token}}">
                                <button type="submit"style="color: #fff;
                                background-color: #20a8d8;
                                border-color: #20a8d8;
                                display: inline-block;
                                font-weight: 400;
                                text-align: center;
                                white-space: nowrap;
                                vertical-align: middle;
                                -webkit-user-select: none;
                                -moz-user-select: none;
                                -ms-user-select: none;
                                user-select: none;
                                border: 1px solid transparent;
                                padding: 0.375rem 0.75rem;
                                font-size: 0.875rem;
                                line-height: 1.5;
                                border-radius: 0;
                            ">Pay R{{ $mail->amount}} to active your plartform</button>
                            </form>
                        </p>
                        <p style="margin-left: 6px">
                            If you experiencing problems, please contact Iconic Code Development. Email: <a href="mailto:{{\CreatyDev\Domain\Users\Models\User::where([['role', '=', 'super-admin']])->first()->email }}">{{\CreatyDev\Domain\Users\Models\User::where([['role', '=', 'super-admin']])->first()->email }}</a> 
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
            </div>
            @include('email_templates._social_media')
        </div>
        </div>
    </div>
</div>
@endif
@if($mail->email_type  == 'customer_registration')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#29363d">
            <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" style="background-color: #e4e5e6">
            <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                        <p style="margin-left: 6px;margin-top: 6%">
                            Dear {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->title }} {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->last_name }}
                        </p>
                        <p style="margin-left: 6px">
                            Thank you for creating an account on  {{ $company->company_name}}. Please be patient as your account is on verification process.
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
            </div>
            @include('email_templates._social_media')
        </div>
        </div>
    </div>
</div>
@endif
@if($mail->email_type  == 'customer_activation')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#29363d">
            <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" style="background-color: #e4e5e6">
            <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                        <p style="margin-left: 6px;margin-top: 6%">
                            Hi there
                        </p>
                        <p style="margin-left: 6px">
                            {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->name }} would like you to verify his/her account.
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
            </div>
            @include('email_templates._social_media')
        </div>
        </div>
    </div>
</div>
@endif

@if($mail->email_type  == 'customer_updated_support_ticket')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#29363d">
            <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" style="background-color: #e4e5e6">
            <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                        <p style="margin-left: 6px;margin-top: 6%">
                            Hi there
                        </p>
                        <p style="margin-left: 6px">
                            A <a href="{{ url('/tickets/'.\CreatyDev\Domain\Ticket\Models\Ticket::find($mail->ticket_id)->ticket_id) }}">support ticket </a> has been updated.
                        </p>
                        <p style="margin-left: 6px">
                            Subject:
                        </p>
                        <p style="margin-left: 6px">

                            {{ \CreatyDev\Domain\Ticket\Models\Category::where('id', '=',  \CreatyDev\Domain\Ticket\Models\Ticket::find($mail->ticket_id)->category_id)->first()->name .' - '. \CreatyDev\Domain\Ticket\Models\Ticket::find($mail->ticket_id)->subject}}
                        </p>
                        <p style="margin-left: 6px">
                            Message:
                        </p>
                        <p style="margin-left: 6px">
                            {{ CreatyDev\Domain\Ticket\Models\Comment::where('id', '=', $mail->comment_id)->first()->comment}}
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
            </div>
            @include('email_templates._social_media')
        </div>
        </div>
    </div>
</div>
@endif

@if($mail->email_type  == 'forgotpassword')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#29363d">
                <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #e4e5e6">
            <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                <p style="margin-left: 6px;margin-top: 6%">
                    {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->name }}
                </p>
                        <p style="margin-left: 6px">
                            You are receiving this email because we received a password reset request for your account on <a href="{{ url('/') }}">{{ $company->company_name}}</a>.
                        </p>
                        <p style="margin-left: 6px;text-align: center">
                            <form method="get" action="{{ url('password/reset/'.$mail->token) }}">
                                <button type="submit"style="color: #fff;
                                background-color: #20a8d8;
                                border-color: #20a8d8;
                                display: inline-block;
                                font-weight: 400;
                                text-align: center;
                                white-space: nowrap;
                                vertical-align: middle;
                                -webkit-user-select: none;
                                -moz-user-select: none;
                                -ms-user-select: none;
                                user-select: none;
                                border: 1px solid transparent;
                                padding: 0.375rem 0.75rem;
                                font-size: 0.875rem;
                                line-height: 1.5;
                                border-radius: 0;
                                ">Reset password</button>
                            </form>
                            
                        </p>
                        <p style="margin-left: 6px">
                            If you did not request a password reset, no further action is required.
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
                    </div>
            @include('email_templates._social_media')
        </div>
    </div>
    </div>
</div>
@endif

@if($mail->email_type  == 'new_support_ticket')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#29363d">
                <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body" style="background-color: #e4e5e6">
        <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                        <p style="margin-left: 6px;margin-top: 6%">
                            Hi there
                        </p>
                        <p style="margin-left: 6px">
                            A new <a href="{{ url('/tickets/'.\CreatyDev\Domain\Ticket\Models\Ticket::find($mail->ticket_id)->ticket_id) }}"> ticket </a> has been created.
                        </p>
                        <p style="margin-left: 6px">
                            Subject:
                        </p>
                        <p style="margin-left: 6px">
                            @if ($mail->file_service_id)
                            {{ 'File Service'.' - '. \CreatyDev\Domain\FileService::find($mail->file_service_id)->make .' - '. \CreatyDev\Domain\FileService::find($mail->file_service_id)->model .' - '. \CreatyDev\Domain\FileService::find($mail->file_service_id)->generation .' - '. \CreatyDev\Domain\FileService::find($mail->file_service_id)->engine}}
                            @else
                            A new ticket has been created
                            @endif
                        </p>
                        <p style="margin-left: 6px">
                            Message:
                        </p>
                        <p style="margin-left: 6px">
                            @if(CreatyDev\Domain\Ticket\Models\Comment::where('id', '=', $mail->comment_id)->first())
                            {{ CreatyDev\Domain\Ticket\Models\Comment::where('id', '=', $mail->comment_id)->first()->comment}}
                            @endif
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
                    </div>
                    @include('email_templates._social_media')
        </div>
    </div>
</div>
</div>
@endif
@if($mail->email_type  == 'updated_support_ticket')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#29363d">
            <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" style="background-color: #e4e5e6">
            <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                        <p style="margin-left: 6px;margin-top: 6%">
                            Hi there
                        </p>
                        <p style="margin-left: 6px">
                            A <a href="{{ url('/tickets/'.\CreatyDev\Domain\Ticket\Models\Ticket::find($mail->ticket_id)->ticket_id) }}">support ticket </a> has been updated.
                        </p>
                        <p style="margin-left: 6px">
                            Subject:
                        </p>
                        <p style="margin-left: 6px">

                            {{ \CreatyDev\Domain\Ticket\Models\Category::where('id', '=',  \CreatyDev\Domain\Ticket\Models\Ticket::find($mail->ticket_id)->category_id)->first()->name .' - '. \CreatyDev\Domain\Ticket\Models\Ticket::find($mail->ticket_id)->subject}}
                        </p>
                        <p style="margin-left: 6px">
                            Message:
                        </p>
                        <p style="margin-left: 6px">
                            @if(CreatyDev\Domain\Ticket\Models\Comment::where('id', '=', $mail->comment_id)->first())
                            {{ CreatyDev\Domain\Ticket\Models\Comment::where('id', '=', $mail->comment_id)->first()->comment}}
                            @endif
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
            </div>
            @include('email_templates._social_media')
        </div>
        </div>
    </div>
</div>
@endif

@if($mail->email_type  == 'order_completed')
<div class="modal fade" id="myEditModal{{ $mail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#29363d">
            <h5 class="modal-title" id="exampleModalLabel" style="width: 100%;margin-left: 6%"> <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" ></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" style="background-color: #e4e5e6">
            <div style="margin-left: 6%;margin-right: 6%;width:88%;background-color: white;">
                        <p style="margin-left: 6px;margin-top: 6%">
                            Hi {{ \CreatyDev\Domain\Users\Models\User::find($mail->user_id)->name }}
                        </p>
                        <p style="margin-left: 6px">
                            We have received the payment for invoice 0010752. Thank you!
                        </p>
                        <p style="margin-left: 6px">
                            Kind regards,
                        </p>
                        <p style="margin-left: 6px">
                            {{ $company->company_name}}
                        </p>
            </div>
            @include('email_templates._social_media')
        </div>
        </div>
    </div>
</div>
@endif