<?php

namespace App;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use Notifiable;
    //
    protected $guarded = [];

    public function from_user(){
        return $this->belongsTo(User::class,'from_user_id');
    }

    public function to_user(){
        return $this->belongsTo(User::class,'to_user_id');
    }
}
