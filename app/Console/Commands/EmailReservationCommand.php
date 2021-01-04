<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// use Facades\App\Libraries\Notifications; // Facades

// use App\Libraries\NotificationsInterface; // Interface service container binding
use App\Libraries\Notifications; // Automatic service container binding
use App\Notifications\Reservation;

class EmailReservationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:notify {count : The number of bookings to retrieve }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify reservation holders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Notifications $notify) // Automatic service container binding
    //  public function __construct(\App\Libraries\Notifications $notify) // Service Providers
    // public function __construct(\App\Libraries\NotificationsInterface $notify) // Interface service container binding
    {
        parent::__construct();
        $this->notify = $notify;
        // dd($this->notify);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $answer = $this->choice('What service should we use?', [ 'SMS', 'EMAIL']);
        var_dump( $answer );
        $count = $this->argument('count');
        if( !is_numeric($count) ){
            $this->alert("The count must be a number");
            return 1;
        }
        //
        $bookings = \App\Booking::with(['room.roomType', 'users'])->limit($count)->get();
        $this->info( sprintf("The number of booking for alert is %d", $bookings->count()) );
        $bar = $this->output->createProgressBar( $bookings->count() );
        $bar->start();        
        foreach( $bookings as $booking ){
            // $this->error(" Nothing Happended ");
            // $this->notify->send(); // Interface service container binding, Service Providers
            // Notifications::send(); //Facades
            $booking->notify(new Reservation($booking->users[0]->name));
            $bar->advance();  
        }
        $bar->finish();
        $this->comment(" Command completed ");
    }
}
