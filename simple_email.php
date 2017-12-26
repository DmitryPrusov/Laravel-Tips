<?php 

/* 
1) 

.env.php:

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=example@gmail.com
MAIL_PASSWORD=****************
MAIL_ENCRYPTION=tls


2) 
https://myaccount.google.com/security

we need to go there and change settings for security

3) php artisan make:mail InquirerNotification

create view there for email text.

4)       
*/
Mail::to('dmytro_prusov@bigmir.net')->send(new InquirerNotification());


// InquirerNotification:

class InquirerNotification extends Mailable
{
    use Queueable, SerializesModels;
    protected $answer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(QuestionAnswer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this
            ->subject('Expert '.$this->answer->expert->name.' has answered on your question')
            ->view('emails.email-for-inquirer')
            ->with([
                'theme' => $this->answer->theme->title,
                'expert' => $this->answer->expert->name, 
                'question_text' => $this->answer->question_text,
                'url' => $this->answer->Url
            ]);
    }
}




 



