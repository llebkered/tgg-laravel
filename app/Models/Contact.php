<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    use HasFactory, Notifiable;

    protected $recipient;
    protected $email;

    public function __construct()
    {
        $this->recipient = config('recipient.name');
        $this->email = config('recipient.email');
    }

    public $fillable = ['name', 'email', 'phone', 'subject', 'message','is_read'];
}
