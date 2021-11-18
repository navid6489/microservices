<?php

namespace App\Providers;

use App\Providers\StudentAssigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\StudentAssignedNotification;
use App\Models\User;
use DB;

class StudentAssignedListener
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
     * @param  StudentAssigned  $event
     * @return void
     */
    public function handle(StudentAssigned $event)
    {
        $studid = $event->studid;
        
        $tid=$event->tid;
        $tname=$event->tname;
        
        User::where('id', $tid)
    ->firstOrFail()
    ->notify(new StudentAssignedNotification($studid));
    }
}
