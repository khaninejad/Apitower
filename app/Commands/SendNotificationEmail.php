<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Contracts\Mail\Mailer;
use App\Feeds;
use App\User;
use Config;
use App\Domains;
use App\Domain_taxonomies;
use App\Domain_txnm;
use App\Domain_feeds;
use App\eventSubscription;
use Carbon\Carbon;
class SendNotificationEmail extends Command implements SelfHandling, ShouldBeQueued {

        use InteractsWithQueue, SerializesModels;


        /**
         * Create a new command instance.
         *
         * @return void
         */

        public function __construct()
        {
                //
			
        }

        /**
         * Execute the command.
         *
         * @return void
         */
        public function handle(Mailer $mailer)
        {
			$event=eventSubscription::where('event_name',"email_feed")->first();
			if($event->count()>=1){
				$dt = Carbon::parse($event->trigged);
				$now=Carbon::now();
				echo "now".$now."<br/>";
				echo Carbon::now()->diffInMinutes(Carbon::parse($event->trigged))."<br/>";
				echo Carbon::parse($event->trigged)->diffInMinutes(Carbon::now())."<br/>";
				echo Carbon::parse($event->trigged)->diffInMinutes(Carbon::now(),false)."<br/>";
				echo Carbon::now()->diffInMinutes(Carbon::parse($event->trigged),false)."<br/>";
				//echo $dt->diffInMinutes();
				if($event->state=="enable" && Carbon::now()->diffInMinutes(Carbon::parse($event->trigged),false)<0){
				 $feed_type="category";
				  $users=User::all();
				  $url=Config::get('app.url');
				  $domains=Domains::all();
				 if($feed_type=="latest"){
					 $feed_posts=Feeds::where('feed_state','unread')->orderBy('created_at', 'desc')->take(10)->get();
					 if(count($feed_posts)>0){
						 foreach($users as $user){
							 $mailer->send('emails.sendnotificationemail', ['feeds'=>$feed_posts,'url'=>$url], function ($m) use( $user) {
								$m->from('support@apitower.com', 'Apitower');
								$m->to($user->email)->subject('New Feeds');
					//
							});
						 }
						 foreach($feed_posts as $feed){
							$feed->feed_state="read";
							$feed->save();
						 }
					 }else{
						 foreach($users as $user){
							 $mailer->send('emails.nofeed', ['user'=>$user,'url'=>$url], function ($m) use( $user) {
								$m->from('support@apitower.com', 'Apitower');
								$m->to($user->email)->subject('No feed');
					//
							});
						 }
					 }
				 }else if($feed_type=="category"){
					
					
					foreach($domains as $domain){
						$domain_taxonomies=Domain_taxonomies::where('domain_id',$domain->id)->where('domain_taxonomy_type','category')->get();
						//dd($domain_taxonomies);
						foreach($domain_taxonomies as $domain_txmns){
							$txnms=Domain_txnm::where('domain_taxonomies_id',$domain_txmns->id)->get();
							foreach($txnms as $txnm){
								echo $txnm->title."-".$txnm->txid. "\n";
								$domain_feeds=Domain_feeds::where('domain_id',$domain->id)->where('domain_category',$txnm->txid)->get()->toArray();
								//print_r($domain_feeds);
								$domain_feeds = array_pluck($domain_feeds,"id");
								//print_r($domain_feeds);
								$feeds=Feeds::whereIn('feeds_id',$domain_feeds)->where('feed_state','unread')->orderBy('created_at', 'desc')->take(10)->get();
								 if(count($feeds)>0){
									 $category_title=$txnm->title;
									 foreach($users as $user){
										 $mailer->send('emails.sendnotificationemail', ['feeds'=>$feeds,'url'=>$url], function ($m) use( $user,$category_title) {
											$m->from('support@apitower.com', 'Apitower');
											$m->to($user->email)->subject('New Feeds: '.$category_title);
								//
										});
									 }
									 foreach($feeds as $feed){
										$feed->feed_state="read";
										$feed->save();
									 }
								 }
							
							}
							
						}
						
					}
		
						 
				 }

				 $event->trigged=$dt->addMinutes($event->period);
				 $event->save();
				}
			}else{
				$users=User::all();
				foreach($users as $user){
					$event=eventSubscription::firstOrCreate(['user_id'=>$user->id,'event_name'=>'email_feed','event_type'=>'category','trigged'=>Carbon::now(),'period'=>1440,'state'=>'enable']);
				}
			}
		 
        }

}