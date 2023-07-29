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
}
