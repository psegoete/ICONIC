@extends('account.layouts.default')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex justify-content-between align-content-center">
                            <h4>Projects</h4>

                            <a href="{{ route('chats.create') }}">Create new chat</a>
                        </div>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($chats as $chat)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $chat->message }}


                            <aside>
                                <a href="{{ route('chats.edit', $chat->id) }}">Edit</a>
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('delete-chat-form-{{ $chat->id }}').submit()">
                                    Delete
                                </a>
                                <form id="delete-chat-form-{{ $chat->id }}" action="{{ route('chats.destroy', $chat->id) }}"
                                      method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </aside>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex justify-content-between align-content-center">
                            <h4>Chats</h4>

                            <a href="{{ route('chats.create') }}">Create new chat</a>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Message</th>
                        <th scope="col">File name</th>
                        <th colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($chats as $chat)
                    <tr>
                        <th scope="row">{{ $chat->message }}</th>
                        <td>{{ $chat->filename }}</td>
                        <td><a href="{{ route('chats.edit', $chat->id) }}">Edit</a></td>
                        <td>
                            <a href="#"
                            onclick="event.preventDefault(); document.getElementById('delete-chat-form-{{ $chat->id }}').submit()">
                                Delete
                            </a>
                            <form id="delete-chat-form-{{ $chat->id }}" action="{{ route('chats.destroy', $chat->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection