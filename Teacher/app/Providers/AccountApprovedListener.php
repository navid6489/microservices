<?php

namespace App\Providers;

use App\Providers\AccountApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\AccountApprovedNotification;
use App\Models\User;
use DB;
class AccountApprovedListener
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
     * @param  AccountApproved  $event
     * @return void
     */
    public function handle(AccountApproved $event)
    {
        $id = $event->id;
       

        User::where('id', $id)
    ->firstOrFail()
    ->notify(new AccountApprovedNotification($id));
    }
}
