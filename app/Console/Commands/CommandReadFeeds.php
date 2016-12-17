<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Queue;
use Illuminate\Queue\QueueManager;
use App\Domain_feeds;
use App\Commands\QueueFeeds;


class CommandReadFeeds extends Command {

        /**
         * The console command name.
         *
         * @var string
         */
        protected $name = 'feeds:read';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Read All feeds';

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct()
        {
                parent::__construct();
        }

        public function handle()
		{
			 $feeds = Domain_feeds::all();
			foreach($feeds as $feed){
				Queue::push(new QueueFeeds($feed));
			}
		}
	
}
		 
		 