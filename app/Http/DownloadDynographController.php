<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CreatyDev\Domain\FileService;
use Illuminate\Support\Facades\Auth;

class DownloadDynographController extends Controller
{
    public function show($id)
    {

        if (Auth::user()->role == 'admin') {
            $file_service = FileService::where([['id', '=', $id], ['company_id', checkDomain()]])->firstOrFail();
        } else {
            $file_service = FileService::where([['id', '=', $id], ['user_id', Auth::user()->id], ['company_id', checkDomain()]])->firstOrFail();
        }

        return response()->download(base_path('public/uploads/') . $file_service->dynograph, $file_service->dynograph_title);
    }
}
