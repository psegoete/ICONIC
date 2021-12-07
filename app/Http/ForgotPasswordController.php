<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Users\Models\User;
use Illuminate\Support\Facades\Validator;
use CreatyDev\Domain\PassworRecover;
use CreatyDev\Domain\ForgotPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\MailHistory;

class ForgotPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showLinkRequestForm()
    {
        return view('forgot_password.email_password');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        // $this->validate($request, [
        //     'email' => 'required'
        // ]);



        $validator = Validator::make(request()->all(), [
            'email' => 'required|email|max:255',
        ]);


        $customer = User::where([['email', '=', $request->input('email')], ['company_id', '=', \checkDomain()]])->get();
        $company = Company::where('id', '=', \checkDomain())->firstOrFail();
        if ($customer->count()) {
            // dd($customer);
            $passwor_recover = new PassworRecover([
                'user_id' => $customer[0]->id,
                'token' => strtoupper(Str::random(70)),
                'status' => "0",
                'company_id' => checkDomain(),
            ]);

            $passwor_recover->save();
            $data = [
                'company_name' => $company->company_name,
                'name' => $customer[0]->name,
                'email' => $customer[0]->email,
                'from' => $company->company_email,
                'subject' => $company->company_name . ' Your password reset link',
                'token' => $passwor_recover->token,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
            ];

            Mail::send('emails.forgotpassword', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject($data['subject']);
            });

            $mail_history = new MailHistory([
                'seen' => 0,
                'from' => $company->company_email,
                'user_id' => $customer[0]->id,
                // 'file_service_id' => $file_service->id,
                // 'comment_id' => $comment->id,
                // 'ticket_id' => $ticket->id,
                'subject' => 'Your password reset link',
                'email_type' => 'forgotpassword',
                // 'sent' => checkDomain(),
                // 'amount' => checkDomain(),
                'company_id' => checkDomain(),
                'token' => $passwor_recover->token,
            ]);
            $mail_history->save();

            // $passwor_recover->save();
            return redirect('password/reset')->withSuccess('Email sent.');
        }

        $validator->errors()->add('email', 'Invalid email.');
        // return redirect('password/reset')->withErrors('Email sent.');
        return redirect()->back()->withErrors($validator)->withInput(request()->all());

        // dd('No');



        // $this->validateEmail($request);

        // // We will send the password reset link to this user. Once we have attempted
        // // to send the link, we will examine the response then see the message we
        // // need to show to the user. Finally, we'll send out a proper response.
        // $response = $this->broker()->sendResetLink(
        //     $this->credentials($request)
        // );

        // return $response == Password::RESET_LINK_SENT
        //             ? $this->sendResetLinkResponse($request, $response)
        //             : $this->sendResetLinkFailedResponse($request, $response);
    }


    public function index()
    {
        return view('auth.passwords.email');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
