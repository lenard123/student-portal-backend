<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MessageThread;
use App\Models\User;
use Illuminate\Http\Request;

class MessageThreadController extends Controller
{
    public function index(Request $request)
    {
        switch ($request->header('user-role')) {
            case User::ROLE_FACULTY:
            case User::ROLE_STUDENT:
                return MessageThread::with('members')
                    ->withCount('messages')
                    ->whereHas('members', function ($query) use ($request) {
                        $query->where('user_id', $request->currentUser()->id);
                    })->get();
            case User::ROLE_ADMIN:
                return MessageThread::with('members')
                    ->withCount('messages')
                    ->where('type', MessageThread::TYPE_ADMIN)->get();
        }
    }

    public function messages(MessageThread $thread)
    {
        return $thread->messages;
    }

    public function findThread(Request $request, User $user)
    {
        return MessageThread::findThread($request->currentUser(), $user);
    }

    public function sendMessage(Request $request, MessageThread $thread)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);
        return $thread->messages()->create(
            $request->only('message') + ['user_id' => $request->currentUser()->id]
        );
    }
}
