<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CreatyDev\Domain\FileService;
use Illuminate\Support\Facades\Auth;

class DownloadModifiedController extends Controller
{
    public function show($id)
    {

        if (Auth::user()->role == 'admin') {
            $file_service = FileService::where([['id', '=', $id], ['company_id', checkDomain()]])->firstOrFail();
        } else {
            $file_service = FileService::where([['id', '=', $id], ['user_id', Auth::user()->id], ['company_id', checkDomain()]])->firstOrFail();
            $file_service->downloaded_file_service = 1;
            $file_service->save();
        }

        // return response()->download(base_path('public/uploads/') . $file_service->modified, $file_service->modified_title);
        // $content = file_get_contents(Storage::disk('public/uploads')->path(base_path('local') . $file_service->modified));
        // return response->json_encode($content);

        return response()->download(base_path('public/uploads/') . $file_service->modified, $file_service->modified_title);
    }
}
