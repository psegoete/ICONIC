<?php

namespace CreatyDev\Http\api;
use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\FileService;
use CreatyDev\Domain\MailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CreatyDev\Domain\MailHistory;
use CreatyDev\Domain\Users\Models\User;
use Illuminate\Support\Facades\Mail;
use CreatyDev\Domain\Ticket\Models\Ticket;
use CreatyDev\Domain\Ticket\Models\Category;
use CreatyDev\Domain\Ticket\Models\Comment;

class MailsController extends Controller
{
    public function index(Request $request)
    {
        $mails =  DB::table('mail_histories')->where([['company_id', '=', checkDomain()]])->paginate(10);
        $company = Company::where('id', '=', \checkDomain())->firstOrFail();

        return view('email_templates.sent_emails', compact('mails', 'company'));
    }

    public function resend($id)
    {
        $mail = MailHistory::where([['company_id', '=', \checkDomain()], ['id', '=', $id]])->firstOrFail();
        $company = Company::where('id', '=', \checkDomain())->firstOrFail();

        if ($mail->email_type == 'new_file_service') {
            $customer = User::where([['id', '=', $mail->user_id], ['company_id', '=', checkDomain()]])->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();
            $file_service = FileService::where([['id', '=', $mail->file_service_id], ['company_id', '=', checkDomain()]])->firstOrFail();

            $data = [
                'company_name' => $company->company_name,
                'admin_name' =>  $admin->name,
                'admin_email' =>  $admin->email,
                'name' =>  $customer->name,
                'email' =>  $customer->email,
                'id' =>  $file_service->id,
                'from' => $company->company_email,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
                'car' =>  $file_service->make . ' ' . $file_service->model . ' ' . $file_service->generation . ' ' . $file_service->engine,
            ];

            Mail::send('emails.new_file_service', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);

                $m->to($data['admin_email'], $data['company_name'])->subject('New file service has been submitted');
            });
        }

        if ($mail->email_type == 'completed_file_service') {
            $customer = User::where([['id', '=', $mail->user_id], ['company_id', '=', checkDomain()]])->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();
            $file_service = FileService::where([['id', '=', $mail->file_service_id], ['company_id', '=', checkDomain()]])->firstOrFail();

            $data = [
                'company_name' => $company->company_name,
                'name' =>  $customer->name,
                'email' =>  $customer->email,
                'from' => $company->company_email,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
                'car' =>  $file_service->make . ' ' . $file_service->model . ' ' . $file_service->generation . ' ' . $file_service->engine,
            ];

            Mail::send('emails.completed_file_service', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject('Your file service is ready!');
            });
        }
        if ($mail->email_type == 'verifaication_account') {
            $customer = User::where('id', '=', $mail->user_id)->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();
            $mail1 = MailTemplate::where([['action', '=', 'verifaication_account'], ['company_id', '=', checkDomain()]])->firstOrFail();

            $data = [
                'company_name' => $company->company_name,
                'admin_name' =>  $admin->name,
                'admin_email' =>  $admin->email,
                'name' =>  $customer->name,
                'body' =>  $mail1->body,
                'subject' =>  $mail->subject,
                'email' =>  $customer->email,
                'from' => $company->company_email,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
            ];

            Mail::send('emails.verification', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject($data['subject']);
            });
        }
        if ($mail->email_type == 'customer_registration') {
            $customer = User::where([['id', '=', $mail->id], ['company_id', '=', checkDomain()]])->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();

            $mail1 = MailTemplate::where([['action', '=', 'user_registered'], ['company_id', '=', checkDomain()]])->firstOrFail();
            $admi_mail = MailTemplate::where([['action', '=', 'customer_activation '], ['company_id', '=', checkDomain()]])->firstOrFail();


            $data = [
                'company_name' => $company->company_name,
                'admin_name' =>  $admin->name,
                'admin_email' =>  $admin->email,
                'name' =>  $customer->name,
                'customer_subject' =>  $mail->subject,
                'body' =>  $mail1->body,
                'admin_body' =>  $admi_mail->body,
                'admin_subject' =>  $admi_mail->subject,
                'email' =>  $customer->email,
                'from' => $company->company_email,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
            ];

            Mail::send('emails.customer_registration', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject($data['customer_subject']);
            });
        }
        if ($mail->email_type == 'customer_activation') {

        $customer = User::where([['id', '=', $mail->id],['company_id','=', checkDomain()]])->firstOrFail();
        $admin = User::where([['role', '=', 'admin'],['company_id','=', checkDomain()]])->firstOrFail();
        
        $mail1 = MailTemplate::where([['action', '=', 'user_registered'],['company_id','=', checkDomain()]])->firstOrFail();
        $admi_mail = MailTemplate::where([['action', '=', 'customer_activation '],['company_id','=', checkDomain()]])->firstOrFail();


        $data = [
            'company_name' => $company->company_name,
            'admin_name' =>  $admin->name,
            'admin_email' =>  $admin->email,
            'name' =>  $customer->name,
            'customer_subject' =>  $mail1->subject,
            'body' =>  $mail1->body,
            'admin_body' =>  $admi_mail->body,
            'admin_subject' =>  $admi_mail->subject,
            'email' =>  $customer->email,
            'from' => $company->company_email,
            'footer' => $company->company_name .' - '. $company->city .' - '. $company->province .', '.$company->country,
        ];

            Mail::send('emails.customer_activation', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);
    
                $m->to($data['email'], $data['company_name'])->subject($data['admin_subject']);
            });
        }
        
        if ($mail->email_type == 'forgotpassword') {
            $customer = User::where([['id', '=', $mail->id], ['company_id', '=', checkDomain()]])->firstOrFail();
            $data = [
                'comapny_name' => $company->company_name,
                'name' => $customer->name,
                'email' => $customer->email,
                'from' => $company->company_email,
                'subject' => $company->company_name . ' Your password reset link',
                'token' => $mail->token,
            ];

            Mail::send('emails.forgotpassword', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['comapny_name']);

                $m->to($data['email'], $data['comapny_name'])->subject($data['subject']);
            });
        }
        if ($mail->email_type == 'close_support_ticket') {

            $customer = User::where([['id', '=', $mail->user_id], ['company_id', '=', checkDomain()]])->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();
            $ticket = Ticket::where('id', '=',  $mail->ticket_id)->firstOrFail();
            $categories = Category::where('id', '=',  $ticket->category_id)->firstOrFail();
            $data = [
                'company_name' => $company->company_name,
                'facebook' => $company->facebook,
                'instagram' => $company->instagram,
                'youtube' => $company->youtube,
                'admin_name' =>  $admin->name,
                'admin_email' =>  $admin->email,
                'name' =>  $customer->name,
                'email' =>  $customer->email,
                'from' => $company->company_email,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
                'message_subject' =>  $categories->name . ' - ' . $ticket->subject,
                'message' =>  Comment::where('id', '=',  $mail->comment_id)->first()->comment,
            ];

            Mail::send('emails.close_support_ticket', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject('A ticket has been closed');
            });

        }
        if ($mail->email_type == 'customer_updated_support_ticket') {

            $customer = User::where([['id', '=', $mail->user_id], ['company_id', '=', checkDomain()]])->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();
            $ticket = Ticket::where('id', '=',  $mail->ticket_id)->firstOrFail();
            $categories = Category::where('id', '=',  $ticket->category_id)->firstOrFail();
            $data = [
                'company_name' => $company->company_name,
                'facebook' => $company->facebook,
                'instagram' => $company->instagram,
                'youtube' => $company->youtube,
                'admin_name' =>  $admin->name,
                'admin_email' =>  $admin->email,
                'name' =>  $customer->name,
                'email' =>  $customer->email,
                'from' => $company->company_email,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
                'message_subject' =>  $categories->name . ' - ' . $ticket->subject,
                'message' =>  Comment::where('id', '=',  $mail->comment_id)->first()->comment,
            ];

            Mail::send('emails.customer_updated_support_ticket', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject('Your ticket has been updated');
            });
        }
        if ($mail->email_type == 'new_support_ticket') {

            $customer = User::where([['id', '=', $mail->user_id], ['company_id', '=', checkDomain()]])->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();
            $ticket = Ticket::where('id', '=',  $mail->ticket_id)->firstOrFail();
            $categories = Category::where('id', '=',  $ticket->category_id)->firstOrFail();
            $data = [
                'company_name' => $company->company_name,
                'facebook' => $company->facebook,
                'instagram' => $company->instagram,
                'youtube' => $company->youtube,
                'admin_name' =>  $admin->name,
                'admin_email' =>  $admin->email,
                'name' =>  $customer->name,
                'email' =>  $customer->email,
                'from' => $company->company_email,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
                'message_subject' =>  $categories->name . ' - ' . $ticket->subject,
                'message' =>  Comment::where('id', '=',  $mail->comment_id)->first()->comment,
            ];

            Mail::send('emails.new_support_ticket', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);
    
                $m->to($data['admin_email'], $data['company_name'])->subject($data['subject']);
            });
        }
        if ($mail->email_type == 'updated_support_ticket') {

            $customer = User::where([['id', '=', $mail->user_id], ['company_id', '=', checkDomain()]])->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();
            $ticket = Ticket::where('id', '=',  $mail->ticket_id)->firstOrFail();
            $categories = Category::where('id', '=',  $ticket->category_id)->firstOrFail();
            $data = [
                'company_name' => $company->company_name,
                'facebook' => $company->facebook,
                'instagram' => $company->instagram,
                'youtube' => $company->youtube,
                'admin_name' =>  $admin->name,
                'admin_email' =>  $admin->email,
                'name' =>  $customer->name,
                'email' =>  $customer->email,
                'from' => $company->company_email,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
                'message_subject' =>  $categories->name . ' - ' . $ticket->subject,
                'message' =>  Comment::where('id', '=',  $mail->comment_id)->first()->comment,
            ];

            Mail::send('emails.updated_support_ticket', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);
    
                $m->to($data['admin_email'], $data['company_name'])->subject($data['subject']);
            });
        }

        return back();
    }
}
