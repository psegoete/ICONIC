<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Projects\Models\Project;
use CreatyDev\Domain\Chat;

class ChatsController extends Controller
{
    public function index()
    {
        $chats = Chat::all();

        return view('chats.index', compact('chats'));
    }

    public function create()
    {
        return view('chats.create');
    }


    //

    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
            'filename' => 'required'
        ]);

        $chat = new Chat([
            'message' => $request->input('message'),
            'filename' => $request->input('filename')
        ]);

        $chat->save();

        return redirect()->route('chats.index')
            ->withSuccess('Chat created successfully.');
    }

    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $chat = Chat::where('id', '=', $id)->firstOrFail();
       return view('chats.edit', compact('chat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {

        $chat = Chat::where('id', '=',$id)->firstOrFail();

        $this->validate($request, [
            'message' => 'required',
            'filename' => 'required'
        ]);
        
        $chat->fill($request->only('message'));
        $chat->fill($request->only('filename'));
        $chat->save();

        return back()->withSuccess('Chat updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $chat = Chat::where('id', '=', $id)->firstOrFail();
        $chat->delete();

        return back()->withSuccess("{$chat->message} project deleted successfully.");
    }
}
