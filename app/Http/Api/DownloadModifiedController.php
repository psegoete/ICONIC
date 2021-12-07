<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CreatyDev\Domain\FileService;
use Illuminate\Support\Facades\Auth;

class DownloadModifiedController extends Controller
{
    public function show($id)
    {

        if (auth('api')->user()->role == 'admin') {
            $file_service = FileService::where([['id', '=', $id], ['company_id', checkDomain()]])->firstOrFail();
        } else {
            $file_service = FileService::where([['id', '=', $id], ['user_id', Auth::user()->id], ['company_id', checkDomain()]])->firstOrFail();
            $file_service->downloaded_file_service = 1;
            $file_service->save();
        }

        return response()->download(public_path('/public/uploads/') . $file_service->modified, $file_service->modified_title);
    }
}
