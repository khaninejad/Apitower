<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Queue;
use App\Domain_feeds;
use App\Commands\QueueFeeds;
use App\Commands\SendNotificationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\QueueManager;
use App\User;
use App\Domains;
use App\Domain_taxonomies;
use App\Domain_txnm;
use App\Feeds;

class QueueController extends Controller {

        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function readfeed()
        {
			/*$feeds = Domain_feeds::all();
			foreach($feeds as $feed){
				Queue::push(new QueueFeeds($feed));
				//echo $feed->id;
			}*/
			$domains=Domains::all();
			foreach($domains as $domain){
				$domain_taxonomies=Domain_taxonomies::where('domain_id',$domain->id)->where('domain_taxonomy_type','category')->get();
				//dd($domain_taxonomies);
				foreach($domain_taxonomies as $domain_txmns){
					$txnm=Domain_txnm::where('domain_taxonomies_id',$domain_txmns->id)->first();
					echo $txnm->title."-".$txnm->txid."<br/>";
					$domain_feeds=Domain_feeds::where('domain_id',$domain->id)->where('domain_category',$txnm->txid)->get()->toArray();
					//print_r($domain_feeds);
					$domain_feeds = array_pluck($domain_feeds,"id");
					//print_r($domain_feeds);
					$feeds=Feeds::whereIn('feeds_id',$domain_feeds)->where('feed_state','unread')->orderBy('created_at', 'desc')->take(10)->get();
					 if(count($feeds)>0){
						 foreach($users as $user){
							 $mailer->send('emails.sendnotificationemail', ['feeds'=>$feeds,'url'=>$url], function ($m) use( $user) {
								$m->from('support@apitower.com', 'Apitower');
								$m->to($user->email)->subject('New Feeds: '.$txnm->title);
					//
							});
						 }
						 foreach($feed_posts as $feed){
							$feed->feed_state="read";
							$feed->save();
						 }
					 }
				}
				
			}

        }
		

        /**
         * Show the form for creating a new resource.
         *
         * @return Response
         */
      
}
?>