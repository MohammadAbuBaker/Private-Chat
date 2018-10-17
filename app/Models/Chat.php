<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Chat extends Model
{
    protected $guarded=[];
    
    public function message(){
        return $this->belongsTo(Message::class);
    }
}
