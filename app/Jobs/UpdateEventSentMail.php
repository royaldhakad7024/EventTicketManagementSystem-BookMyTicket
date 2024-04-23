<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Notifications\EventUpdateNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateEventSentMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /**
         * Get the event id from the argument of construct
         * Get the user id from the order table
         * Get user id from user table
         */
        $user_id = Order::where('event_id', $this->id)->pluck('user_id');
        $user_ids = User::whereIn('id', $user_id)->pluck('id')->unique();

        /**
         * Find user info from user table and sent email notification to each user.
         * Get order id , user name and event id along with notification to sent email.
         */
        foreach ($user_ids as $userId) {
            $user = User::find($userId);
            $order_id = Order::where('user_id', $user->id)->where('event_id', $this->id)->pluck('id')->first();
            $user->notify(new EventUpdateNotification($this->id, $user->name, $order_id));
        }
    }
}