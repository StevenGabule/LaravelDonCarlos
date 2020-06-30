<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ReplyToUser extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $mail = $this->from(Auth::user()->email)
            ->subject($this->data['subject'])
            ->markdown('backend.template-mail.index')->with('data', $this->data);
        if (!is_null($this->data['file'])) {
            if (is_array($this->data['file'])) {
                foreach ($this->data['file'] as $file) {
                    $mail->attach($file->getRealPath(), [
                        'as'=> $file->getClientOriginalName()
                    ]);
                }
            } else {
                $mail->attach($this->data['file']->getRealPath(), [
                    'as'=> $this->data['file']->getClientOriginalName()
                ]);
            }
        }
        return $mail;
    }
}
