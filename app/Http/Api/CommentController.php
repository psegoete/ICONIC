<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Ticket\Models\Ticket;
use CreatyDev\Domain\Ticket\Models\Comment;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\UserDevice;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\Ticket\Models\Category;
use CreatyDev\Domain\UserCompanyCredit;
use Illuminate\Support\Facades\Mail;
use CreatyDev\Domain\MailHistory;

class CommentController extends Controller
{
    public function show($ticket_id)
    {

        $ticket = Ticket::where([['company_id', '=', auth('api')->user()->company_id], ['ticket_id', '=', $ticket_id]])->orderBy('created_at', 'asc')->firstOrFail();
        // $comments = Comment::where('ticket_id', '=', $ticket->id)->orderBy('created_at', 'desc')->get();

        $comments =  Comment::where([['comments.company_id', '=', auth('api')->user()->company_id],['ticket_id', '=', $ticket->id]])
                    ->leftJoin('users', 'comments.user_comment_id', '=', 'users.id')
                    ->select(
                        'comments.id',
                        'comments.comment',
                        'comments.ticket_id',
                        'comments.user_comment_id',
                        'comments.file_name',
                        'comments.file_name_title',
                        'comments.id',
                        'users.first_name',
                        'users.last_name',
                        'users.ticket_display_name',
                        'comments.created_at',
                    )
                    ->orderByRaw('comments.updated_at desc')
                    ->get();

        return response()->json(['comments' => $comments], 200);
    }

    public function store(Request $request)
    {

        $ticket = Ticket::where([['id', '=', $request->input('ticket_id')], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();


        $comment = new Comment([
            'ticket_id' => $request->input('ticket_id'),
            'user_id' => $ticket->user_id,
            'user_comment_id' => auth('api')->user()->id,
            'company_id' => auth('api')->user()->company_id,
        ]);

        $headers = array(
            'Authorization: key=' . 'AAAAYmXd74U:APA91bEqPL0LXy2ida9tbYPg_WsDbkaBUZQ5hBsk_U5pbemFld7QmwBhxkSJuN34Th-D6z8Oq9Rr_rv6IYXREf3hogWeRURnW2zriPnwgaa3NRp7OYCrjjQdf2YK9uu3WPnjzV50M_cb',
            'Content-Type: application/json'
        );


        if ($request->file('comment_file')) {
            // $request->file('comment_file')->store('public/uploads');
            $name = $request->file('comment_file')->hashName();
            $request->file('comment_file')->move(base_path('public/uploads'), $name);
            $comment->file_name = $name;
            $comment->file_name_title = $request->file('comment_file')->getClientOriginalName();
        }
        // return response()->json(['comments' => $request->file('comment_file')], 200);



        if ($request->input('comment') || $request->file('comment_file')) {
            $credits = UserCompanyCredit::where([['company_id', '=', auth('api')->user()->company_id]])->first();
            if (companyPlan() != 'enterprice' &&  $request->file('comment_file')) {
                if (auth('api')->user()->role == 'admin') {
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

        $company = Company::where('id', '=', \auth('api')->user()->company_id)->firstOrFail();
        $customer = User::where([['id', '=', $ticket->user_id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $admin = User::where([['role', '=', 'admin'], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
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

        if (auth('api')->user()->role == 'customer' && ($request->input('comment') || $request->file('comment_file'))) {
            $ticket->status = "Open";

            $devices = UserDevice::where([['user_id', '=', $admin->id], ['company_id', '=', auth('api')->user()->company_id]])->get();

            foreach ($devices as $key => $value) {
    
                if ($request->input('comment') || $request->file('comment_file')) {
                    // $comment->save();
                    $fields = array(
                        'to' => $value->device_id,
                        'notification' => array(
                            'body' => $comment->comment . ' ' . $comment->file_name_title,
                            'title' => auth('api')->user()->name . ' - ' . $categories->name,
                            'icon'  => 'myicon',/*Default Icon*/
                            'sound' => 'mySound'/*Default sound*/
                        )
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    $result = curl_exec($ch);
                    curl_close($ch);
                } else {
                    $fields = array(
                        'to' => $value->device_id,
                        'notification' => array(
                            'body' => $ticket->subject,
                            'title' => auth('api')->user()->name . ' - ' . $categories->name,
                            'icon'  => 'myicon',/*Default Icon*/
                            'sound' => 'mySound'/*Default sound*/
                        )
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    $result = curl_exec($ch);
                    curl_close($ch);
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
                // 'sent' => auth('api')->user()->company_id,
                // 'amount' => auth('api')->user()->company_id,
                'company_id' => auth('api')->user()->company_id,
                // 'token' => auth('api')->user()->company_id,
            ]);
            $mail_history->save();
        }

        if (auth('api')->user()->role == 'admin' && ($request->input('comment') || $request->file('comment_file'))) {

            $devices = UserDevice::where([['user_id', '=', $customer->id], ['company_id', '=', auth('api')->user()->company_id]])->get();

            foreach ($devices as $key => $value) {
    
                if ($request->input('comment') || $request->file('comment_file')) {
                    $comment->save();
                    $fields = array(
                        'to' => $value->device_id,
                        'notification' => array(
                            'body' => $comment->comment . ' ' . $comment->file_name_title,
                            'title' => auth('api')->user()->ticket_display_name . ' - ' . $categories->name,
                            'icon'  => 'myicon',/*Default Icon*/
                            'sound' => 'mySound'/*Default sound*/
                        )
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    $result = curl_exec($ch);
                    curl_close($ch);
                } else {
                    $fields = array(
                        'to' => $value->device_id,
                        'notification' => array(
                            'body' => $ticket->subject,
                            'title' => auth('api')->user()->ticket_display_name . ' - ' . $categories->name,
                            'icon'  => 'myicon',/*Default Icon*/
                            'sound' => 'mySound'/*Default sound*/
                        )
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    $result = curl_exec($ch);
                    curl_close($ch);
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
                // 'sent' => auth('api')->user()->company_id,
                // 'amount' => auth('api')->user()->company_id,
                'company_id' => auth('api')->user()->company_id,
                // 'token' => auth('api')->user()->company_id,
            ]);
            $mail_history->save();
        }


        if ($request->input('status')) {
            if (auth('api')->user()->role == 'admin') {
                if ($request->input('comment') || $request->file('comment_file')) {
                    $ticket->customer_view_status = "Open";
                    $ticket->customer_viewed_status = 'Open';
                    $ticket->admin_view_status = "Closed";
                } else {
                    $ticket->admin_view_status = "Closed";
                }
                $ticket->status = "Closed";

                $devices = UserDevice::where([['user_id', '=', $customer->id], ['company_id', '=', auth('api')->user()->company_id]])->get();

            foreach ($devices as $key => $value) {
                    $fields = array(
                        'to' => $value->device_id,
                        'notification' => array(
                            'body' => $ticket->subject.' '.' ticket has been closed.',
                            'title' => auth('api')->user()->ticket_display_name . ' - ' . $categories->name,
                            'icon'  => 'myicon',/*Default Icon*/
                            'sound' => 'mySound'/*Default sound*/
                        )
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    $result = curl_exec($ch);
                    curl_close($ch);

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
                // 'sent' => auth('api')->user()->company_id,
                // 'amount' => auth('api')->user()->company_id,
                'company_id' => auth('api')->user()->company_id,
                // 'token' => auth('api')->user()->company_id,
            ]);
            $mail_history->save();
            }
            } else {
                if ($request->input('comment') || $request->file('comment_file')) {
                    $ticket->customer_view_status = "Closed";
                    $ticket->admin_view_status = "Open";
                } else {
                    $ticket->customer_view_status = "Closed";
                }
            }
            // $ticket->save();

        } else {
            $ticket->customer_view_status = "Open";
            $ticket->customer_viewed_status = 'Open';
            $ticket->admin_view_status = "Open";
        }
        $ticket->save();

        return response()->json(['success' => 'Successful'], 200);
    }
}

