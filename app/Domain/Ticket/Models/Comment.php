<?php

namespace CreatyDev\Domain\Ticket\Models;

use Illuminate\Database\Eloquent\Model;
use CreatyDev\Domain\Users\Models\User;

class Comment extends Model
{
    protected $fillable = [
    'ticket_id', 'user_id', 'comment','file_name','file_name_title','user_comment_id','company_id'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
