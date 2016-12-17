<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Queue;
use Illuminate\Queue\QueueManager;
use App\Commands\SendNotificationEmail;
class SendNotificationEmails extends Command {

        /**
         * The console command name.
         *
         * @var string
         */
        protected $name = 'emails:SendNotificationEmails';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'This commend used to send feeds notification emails to users';

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
         * @return mixed
         */
        public function fire()
        {
                //
				Queue::push(new SendNotificationEmail());
        }

}