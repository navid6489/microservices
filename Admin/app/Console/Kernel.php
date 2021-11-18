<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Notifications\DailyNotification;
use App\Models\User;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            //getting token
            header("Access-Control-Allow-Origin: *");
            //ALLOW OPTIONS METHOD
            $headers = [
                'Access-Control-Allow-Methods' => 'POST,GET,OPTIONS,PUT,DELETE',
                'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization',
            ];
      
              
         //updating teacher users in teacher microservice
         $client = new \GuzzleHttp\Client();
         $r = $client->request('POST', 'http://127.0.0.1:8000/api/generatetoken', [
            'headers'     => ['X-CSRF-Token'=> csrf_token()],
           
       ]);
    
        $token = $r->getBody()->getContents();

       //getting data from teacher and student

       $client = new \GuzzleHttp\Client();
        
       $r = $client->request('POST', 'http://127.0.0.1:8000/api/getData', [
           'headers'     => ['X-CSRF-Token'=> csrf_token(),
                               'Authorization' => 'Bearer ' . $token],
           
      ]);

       $response = $r->getBody()->getContents();
       $response= json_decode($response);
       
       $teacher=collect($response->teacher);
       $student=collect(json_decode($response->student));








			$list=null;
		
        
        foreach ($teacher as $teacher2){ 
            $list=$list.$teacher2->name.", ";
            }
            foreach ($student as $student2){ 
                $list=$list.$student2->name.", ";
                }
             User::where('role', 'admin')
    ->firstOrFail()
    ->notify(new DailyNotification($list));
        })->everyMinute();
		
    
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
