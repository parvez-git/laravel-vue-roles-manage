<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'to',
        'from',
        'message',
        'read'
    ];

    public function fromUser()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
}
