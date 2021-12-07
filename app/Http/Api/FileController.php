<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use CreatyDev\Domain\FileService;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function show($id)
    {
        if (auth('api')->user()->role == 'admin') {
            $file_service = FileService::where([['id', '=', $id], ['company_id', checkDomain()]])->firstOrFail();
        } else {
            $file_service = FileService::where([['id', '=', $id], ['user_id', Auth::user()->id], ['company_id', checkDomain()]])->firstOrFail();
        }

        return response()->download(base_path('public/uploads/') . $file_service->file_to_modify, $file_service->file_to_modify_title);
    }
}
