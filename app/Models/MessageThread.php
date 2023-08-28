<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageThread extends Model
{
    use HasFactory;

    const TYPE_DIRECT_MESSAGE = 'direct';
    const TYPE_ADMIN = 'admin';

    public function members()
    {
        return $this->belongsToMany(User::class, 'message_thread_user', 'message_thread_id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public static function findThread($user1, $user2)
    {
        $thread = MessageThread::where('type', MessageThread::TYPE_DIRECT_MESSAGE)->whereHas('members', function ($query) use ($user1) {
            $query->where('user_id', $user1->id);
        })->whereHas('members', function ($query) use ($user2) {
            $query->where('user_id', $user2->id);
        })->first();
        if (!$thread) {
            $thread = MessageThread::create(['type' => MessageThread::TYPE_DIRECT_MESSAGE]);
            $thread->members()->attach([$user1->id, $user2->id]);
        }
        return $thread;
    }
}
