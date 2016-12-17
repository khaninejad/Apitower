<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Contracts\Mail\Mailer;
use App\Domain_feeds;
use App\Feeds;

class QueueFeeds extends Command implements SelfHandling, ShouldBeQueued {

        use InteractsWithQueue, SerializesModels;

        /**
         * Create a new command instance.
         *
         * @return void
         */
		protected $feeds;
        public function __construct(Domain_feeds $feeds)
        {
                //
			$this->feeds = $feeds;
        }

        /**
         * Execute the command.
         *
         * @return void
         */
        public function handle(Mailer $mailer)
        {
		$feed = \Feeds::make($this->feeds->domain_feed);
		 $feed->strip_attributes(true);
		$data = array(
		  'title'     => $feed->get_title(),
		  'permalink' => $feed->get_permalink(),
		  'items'     => $feed->get_items(),
		);
			foreach($feed->get_items() as $item){
		$feed_new=Feeds::firstOrCreate(['feeds_id'=> $this->feeds->id,'feed_title'=> $item->get_title(),'feed_url'=>$item->get_permalink()]);
		$feed_new->feed_state='unread';
		$feed_new->feed_description=strip_tags($item->get_description());
		$feed_new->save();
			}
          /*  $mailer->send('emails.welcome', ['items' => $feed->get_items(),'feed'=>$this->feeds], function ($m) {
		    $m->from('support@apitower.com', 'Apitower');,'feed_state'=>'unread'
		    $m->to("khaninejad@gmail.com")->subject('How is your service?');

        });*/
        }

}