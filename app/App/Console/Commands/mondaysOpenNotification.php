<?php

namespace CreatyDev\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use CreatyDev\Domain\UserDevice;
use CreatyDev\Domain\Users\Models\User;

class mondaysOpenNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mondays:opennotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monday open push notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user_devise = UserDevice::where('company_id', '=', 1)->whereNotIn('user_id',[1])->get();

        $headers = array(
            'Authorization: key=' . 'AAAAYmXd74U:APA91bEqPL0LXy2ida9tbYPg_WsDbkaBUZQ5hBsk_U5pbemFld7QmwBhxkSJuN34Th-D6z8Oq9Rr_rv6IYXREf3hogWeRURnW2zriPnwgaa3NRp7OYCrjjQdf2YK9uu3WPnjzV50M_cb',
            'Content-Type: application/json'
        );
        foreach ($user_devise as $key => $value) {
    
            $fields = array(
                'to' => $value['device_id'],
                'notification' => array(
                    'body' => 'Please note we are closing in 30min, any new request will join the queue for next business day',
                    'title' => 'Reminder',
                    'icon'  => 'myicon',/*Default Icon*/
                    'sound' => 'mySound'/*Default sound*/
                )
            );
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
        }
        $this->info('Reminder');

    }
}
