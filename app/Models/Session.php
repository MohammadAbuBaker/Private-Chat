<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Chat;
use App\Models\Message;


class Session extends Model
{
    protected $guarded=[];
    public function chats(){

        return $this->hasManyThrough(Chat::class,Message::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }
}
