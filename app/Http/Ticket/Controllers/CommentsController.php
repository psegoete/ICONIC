<?php

namespace CreatyDev\Http\Ticket\Controllers;

use Illuminate\Http\Request;
use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\FileShareCredit;

use CreatyDev\Domain\Ticket\Models\Comment;
use CreatyDev\Domain\Ticket\Mail\SendTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use CreatyDev\Domain\Ticket\Models\Ticket;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\Ticket\Models\Category;
use CreatyDev\Domain\UserCompanyCredit;
use Illuminate\Support\Facades\Mail;
use CreatyDev\Domain\MailHistory;
use CreatyDev\Domain\UserDevice;
use SebastianBergmann\Type\NullType;

class CommentsController extends Controller
{
    public function postComment(Request $request)
    {
        $ticket = Ticket::where([['id', '=', $request->input('ticket_id')], ['company_id', '=', checkDomain()]])->firstOrFail();

        $comment = new Comment([
            'ticket_id' => $request->input('ticket_id'),
            'user_id' => $ticket->user_id,
            'user_comment_id' => Auth::user()->id,
            'company_id' => checkDomain(),
        ]);


        if ($request->file('comment_file')) {
            // $request->file('comment_file')->store('public/uploads');
            $name = $request->file('comment_file')->hashName();
            $request->file('comment_file')->move(base_path('public/uploads'), $name);
            $comment->file_name = $name;
            $comment->file_name_title = $request->file('comment_file')->getClientOriginalName();
        }



        if ($request->input('comment') || $request->file('comment_file')) {
            $credits = UserCompanyCredit::where([['company_id', '=', checkDomain()]])->first();
            if (companyPlan() != 'enterprice' &&  $request->file('comment_file')) {
                if (Auth::user()->role == 'admin') {
                    if ($credits->credits > 0) {
                        $credits->credits = $credits->credits - 1;
                        $credits->save();
                    } else {
                        return redirect()->back()->with("error", "Insufficient sharing credits. Please buy sharing credits.");
                    }
                }
            }
        } else {
            // return redirect()->back()->with("error", "Ensure either message or attachment field is not empty.");
        }
        // $comment_text = null;
        if ($request->input('comment') || $request->file('comment_file')) {
            $comment->comment = $request->input('comment');
            $comment_text = $comment->id;
            $comment->save();
        }

        $company = Company::where('id', '=', \checkDomain())->firstOrFail();
        $customer = User::where([['id', '=', $ticket->user_id], ['company_id', '=', checkDomain()]])->firstOrFail();
        $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();
        $categories = Category::where('id', '=',  $ticket->category_id)->firstOrFail();

        if ($categories->name == "General question") {
            $tickets_subject = "A ticket has been updated";
        } else {
            $tickets_subject = "A ticket has been updated";
        }

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
            'message' =>  $request->input('comment'),
        ];

        if (Auth::user()->role == 'customer' && ($request->input('comment') || $request->file('comment_file'))) {
            $devices = UserDevice::where([['user_id', '=', $admin->id], ['company_id', '=', checkDomain()]])->get();

            foreach ($devices as $key => $value) {
    
                if ($request->input('comment') || $request->file('comment_file')) {
                    // $comment->save();
                    // $fields = array(
                    //     'to' => $value->device_id,
                    //     'notification' => array(
                    //         'body' => $comment->comment . ' ' . $comment->file_name,
                    //         'title' => auth('api')->user()->name . ' - ' . $categories->name,
                    //         'icon'  => 'myicon',/*Default Icon*/
                    //         'sound' => 'mySound'/*Default sound*/
                    //     )
                    // );
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    // curl_setopt($ch, CURLOPT_POST, true);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    // $result = curl_exec($ch);
                    // curl_close($ch);
                    pushNotification($value->device_id, $comment->comment . ' ' . $comment->file_name_title, auth()->user()->name . ' - ' . $categories->name);

                } else {
                    // $fields = array(
                    //     'to' => $value->device_id,
                    //     'notification' => array(
                    //         'body' => $ticket->subject,
                    //         'title' => auth('api')->user()->name . ' - ' . $categories->name,
                    //         'icon'  => 'myicon',/*Default Icon*/
                    //         'sound' => 'mySound'/*Default sound*/
                    //     )
                    // );
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    // curl_setopt($ch, CURLOPT_POST, true);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    // $result = curl_exec($ch);
                    // curl_close($ch);
                    pushNotification($value->device_id, $ticket->subject, auth()->user()->name . ' - ' . $categories->name);

                }
            }
            Mail::send('emails.updated_support_ticket', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);

                $m->to($data['admin_email'], $data['company_name'])->subject('A ticket has been updated');
            });

            $mail_history = new MailHistory([
                'seen' => 0,
                'from' => $company->company_email,
                'user_id' => $admin->id,
                // 'file_service_id' => $file_service->id,
                'comment_id' => $comment->id,
                'ticket_id' => $ticket->id,
                'subject' => 'Your ticket has been updated',
                'email_type' => 'customer_updated_support_ticket',
                // 'sent' => checkDomain(),
                // 'amount' => checkDomain(),
                'company_id' => checkDomain(),
                // 'token' => checkDomain(),
            ]);
            $mail_history->save();
        }

        if (Auth::user()->role == 'admin' && ($request->input('comment') || $request->file('comment_file'))) {
            
            $devices = UserDevice::where([['user_id', '=', $customer->id], ['company_id', '=', checkDomain()]])->get();

            foreach ($devices as $key => $value) {
    
                if ($request->input('comment') || $request->file('comment_file')) {
                    $comment->save();
                    // $fields = array(
                    //     'to' => $value->device_id,
                    //     'notification' => array(
                    //         'body' => $comment->comment . ' ' . $comment->file_name,
                    //         'title' => auth('api')->user()->name . ' - ' . $categories->name,
                    //         'icon'  => 'myicon',/*Default Icon*/
                    //         'sound' => 'mySound'/*Default sound*/
                    //     )
                    // );
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    // curl_setopt($ch, CURLOPT_POST, true);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    // $result = curl_exec($ch);
                    // curl_close($ch);

                 pushNotification($value->device_id, $comment->comment . ' ' . $comment->file_name_title, auth()->user()->name . ' - ' . $categories->name);

                } else {
                    // $fields = array(
                    //     'to' => $value->device_id,
                    //     'notification' => array(
                    //         'body' => $ticket->subject,
                    //         'title' => auth('api')->user()->name . ' - ' . $categories->name,
                    //         'icon'  => 'myicon',/*Default Icon*/
                    //         'sound' => 'mySound'/*Default sound*/
                    //     )
                    // );
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    // curl_setopt($ch, CURLOPT_POST, true);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    // $result = curl_exec($ch);
                    // curl_close($ch);
                    pushNotification($value->device_id, $ticket->subject, auth()->user()->name . ' - ' . $categories->name);
                }
            }
            Mail::send('emails.customer_updated_support_ticket', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject('Your ticket has been updated');
            });

            $mail_history = new MailHistory([
                'seen' => 0,
                'from' => $company->company_email,
                'user_id' => $ticket->user_id,
                // 'file_service_id' => $file_service->id,
                'comment_id' => $comment->id,
                'ticket_id' => $ticket->id,
                'subject' => 'Your ticket has been updated',
                'email_type' => 'customer_updated_support_ticket',
                // 'sent' => checkDomain(),
                // 'amount' => checkDomain(),
                'company_id' => checkDomain(),
                // 'token' => checkDomain(),
            ]);
            $mail_history->save();
        }


        if ($request->input('status')) {
            if (Auth::user()->role == 'admin') {
                if ($request->input('comment') || $request->file('comment_file')) {
                    $ticket->customer_view_status = "Open";
                    $ticket->customer_viewed_status = 'Open';
                    $ticket->admin_view_status = "Closed";
                } else {
                    $ticket->admin_view_status = "Closed";
                }
            } else {
                if ($request->input('comment') || $request->file('comment_file')) {
                    $ticket->customer_view_status = "Closed";
                    $ticket->admin_view_status = "Open";
                } else {
                    $ticket->customer_view_status = "Closed";
                }
            }
            $ticket->save();

            $devices = UserDevice::where([['user_id', '=', $customer->id], ['company_id', '=', checkDomain()]])->get();

            foreach ($devices as $key => $value) {
                    pushNotification($value->device_id, $ticket->subject.' '.'The ticket has been closed.', auth()->user()->name . ' - ' . $categories->name);
            }

            Mail::send('emails.close_support_ticket', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject('A ticket has been closed');
            });

            $mail_history = new MailHistory([
                'seen' => 0,
                'from' => $company->company_email,
                'user_id' => $ticket->user_id,
                // 'file_service_id' => $file_service->id,
                'comment_id' => $comment->id,
                'ticket_id' => $ticket->id,
                'subject' => 'A ticket has been closed',
                'email_type' => 'close_support_ticket',
                // 'sent' => checkDomain(),
                // 'amount' => checkDomain(),
                'company_id' => checkDomain(),
                // 'token' => checkDomain(),
            ]);
            $mail_history->save();
        } else {
            $ticket->customer_view_status = "Open";
            $ticket->customer_viewed_status = 'Open';
            $ticket->admin_view_status = "Open";
            $ticket->save();
        }

        return redirect()->back()->with("status", "Your comment has be submitted.");
    }

    public function commentFile($id)
    {
        if (Auth::user()->role == 'admin') {
            $comment = Comment::where([['id', '=', $id], ['company_id', '=', checkDomain()]])->firstOrFail();
            return response()->download(base_path('public/uploads/') . $comment->file_name, $comment->file_name_title);
            // return Storage::download('public/uploads/' . $comment->file_name, $comment->file_name_title);
        } else if (Auth::user()->role == 'customer') {
            $comment = Comment::where([['id', '=', $id], ['company_id', '=', checkDomain()], ['user_id', '=', auth::user()->id]])->firstOrFail();
            // return Storage::download('public/uploads/' . $comment->file_name, $comment->file_name_title);
            return response()->download(base_path('public/uploads/') . $comment->file_name, $comment->file_name_title);
        }
    }
}
