<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CreatyDev\Domain\FileService;
use Illuminate\Support\Facades\Auth;

class DownloadDynographController extends Controller
{
    public function show($id)
    {

        if (auth('api')->user()->role == 'admin') {
            $file_service = FileService::where([['id', '=', $id], ['company_id', auth('api')::user()->company_id]])->firstOrFail();
        } else {
            $file_service = FileService::where([['id', '=', $id], ['user_id', auth('api')::user()->id], ['company_id', auth('api')::user()->company_id]])->firstOrFail();
        }

        return response()->download(base_path('public/uploads/') . $file_service->dynograph, $file_service->dynograph_title);
    }
}