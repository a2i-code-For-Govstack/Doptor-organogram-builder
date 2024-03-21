<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UniMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): UniMail
    {
        if ($this->details['template'] == config('notifiable_constants.pass_change')) {
            return $this->subject($this->details['subject'])->view('mail.pass_change');
        } elseif ($this->details['template'] == config('notifiable_constants.profile_pic_change')) {
            return $this->subject($this->details['subject'])->view('mail.profile_pic_change');
        } elseif ($this->details['template'] == config('notifiable_constants.sign_change')) {
            return $this->subject($this->details['subject'])->view('mail.sign_change');
        } elseif ($this->details['template'] == config('notifiable_constants.protikolpo_revert')) {
            return $this->subject($this->details['subject'])->view('mail.protikolpo_cancel');
        } elseif ($this->details['template'] == config('notifiable_constants.application_registered')) {
            return $this->subject($this->details['subject'])->view('mail.application_registered');
        } elseif ($this->details['template'] == 'common_notification_template') {
            return $this->subject($this->details['subject'])->view('mail.common_notification_template');
        } else {
            return $this->subject('No Reply')->view('mail.default');
        }
    }
}
