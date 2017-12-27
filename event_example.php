<?php 
/* 
1) Go to EventServiceProvider.php:

    protected $listen = [
        'App\Events\AfterUpdateBread' => [
            'App\Listeners\SendEmailToInquirer'
        ],
    ];

2) php artisan event:generate

3) */

class AfterUpdateBread
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $answer;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($slug, $id)
    {
        if ($slug == 'questions-answers') {
            $answer= QuestionAnswer::where('id', $id)->first();
            $this->answer = $answer;
        }
        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

// 4) 

class SendEmailToInquirer
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AfterUpdateBread  $event
     * @return void
     */
    public function handle(AfterUpdateBread $event)
    {
        Mail::to($event->answer->email_inquirer)->send(new InquirerNotification($event->answer));
        
    }
}


// 5) After that - adding event in a place where we need it:

 event(new AfterUpdateBread($slug, $id));

