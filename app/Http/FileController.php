<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use CreatyDev\Domain\FileService;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\Ticket\Models\Comment;


class FileController extends Controller
{
    public function show($id)
    {
        if (Auth::user()->role == 'admin') {
            $file_service = FileService::where([['id', '=', $id], ['company_id', checkDomain()]])->firstOrFail();
        } else {
            $file_service = FileService::where([['id', '=', $id], ['user_id', Auth::user()->id], ['company_id', checkDomain()]])->firstOrFail();
        }

        return response()->download(base_path('public/uploads/') . $file_service->file_to_modify, $file_service->file_to_modify_title);
    }
    public function modified($id)
    {
        $file_service = FileService::where([['id', '=', $id], ['company_id', 1]])->firstOrFail();
        return response()->download(base_path('public/uploads/') . $file_service->file_to_modify, $file_service->file_to_modify_title);
    }
    public function comment($id)
    {

        $comment = Comment::where([['id', '=', $id], ['company_id', '=', 1]])->firstOrFail();
        return response()->download(base_path('public/uploads/') . $comment->file_name, $comment->file_name_title);
    }
}
