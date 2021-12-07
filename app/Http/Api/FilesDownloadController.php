<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\FileService;
use Illuminate\Support\Facades\Storage;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\Users\Models\User;
use Illuminate\Support\Facades\Mail;

class FilesDownloadController extends Controller
{
    public function originalFile($id)
    {
        // if (auth('api')->user()->role == 'admin') {
        //     $file_service = FileService::where([['id', '=', $id], ['company_id', auth('api')->user()->company_id]])->firstOrFail();
        // } else if (auth('api')->user()->role == 'customer') {
        //     $file_service = FileService::where([['id', '=', $id], ['user_id', auth('api')->user()->id], ['company_id', auth('api')->user()->company_id]])->firstOrFail();
        // }
        $file_service = FileService::where([['id', '=', $id], ['company_id', 1]])->firstOrFail();
        return response()->download(base_path('public/uploads/') . $file_service->file_to_modify, $file_service->modified_title);
    }


    public function emailFileServiceLink($id)
    {
        // return response()->json(['status' => 'Email sent file service']);
        $customer = User::where([['id', '=', auth('api')->user()->id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $company = Company::where('id', '=', auth('api')->user()->company_id)->firstOrFail();
        $data = [
            'company_name' => $company->company_name,
            'name' => $customer->name,
            'email' => $customer->email,
            'from' => $company->company_email,
            'id' => $id,
            'subject' => 'File service download request',
            'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
        ];

        Mail::send('emails.emailFileService', ['data' => $data], function ($m) use ($data) {
            $m->from($data['from'], $data['company_name']);

            $m->to($data['email'], $data['company_name'])->subject($data['subject']);
        });

        return response()->json(['status' => 'Email sent file service']);
    }

    public function emailCommentLink($id)
    {
        $customer = User::where([['id', '=', auth('api')->user()->id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $company = Company::where('id', '=', auth('api')->user()->company_id)->firstOrFail();
        $data = [
            'company_name' => $company->company_name,
            'name' => $customer->name,
            'email' => $customer->email,
            'from' => $company->company_email,
            'id' => $id,
            'subject' => 'Comment file download request',
            'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
        ];

        Mail::send('emails.emailComment', ['data' => $data], function ($m) use ($data) {
            $m->from($data['from'], $data['company_name']);

            $m->to($data['email'], $data['company_name'])->subject($data['subject']);
        });

        return response()->json(['status' => 'Email sent comment']);
    }
}
