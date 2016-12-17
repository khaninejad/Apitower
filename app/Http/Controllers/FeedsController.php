<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFeedStore;
use Illuminate\Http\Request;

use Input;
use App\Domains;
use App\Domain_taxonomies;
use App\Domain_txnm;
use App\Domain_feeds;
use Redirect;
use App\Libraries\Permissions;
use Auth;
use DB;
use App\Feeds;
use Carbon\Carbon;
use Artisan ;
class FeedsController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}
	public function index()
	{
		//
		 $feeds = Domain_feeds::all();
		// print_r($domains);
		 //die("err");
		return view('feeds.index',['title'=>'Feeds','feeds'=>$feeds]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$domains = Domains::all();
		return view('feeds.create',['title'=>'New Feed','domains'=>$domains]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(PostFeedStore $request)
	{
					$feedCount=Domain_feeds::count();

					$Domain_feeds=new Domain_feeds();
					$Domain_feeds->domain_id= $request->input('domain_id');
					$Domain_feeds->domain_category= $request->input('domain_category');
					$Domain_feeds->domain_url= $request->input('domain_url');
					$Domain_feeds->domain_feed= $request->input('domain_feed');
					$Domain_feeds->Save();

					return Redirect::to('feeds')->with('message', 'Sussessfully Created!');

	}



	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$Domain_feeds = Domain_feeds::find($id);

		$Domain_feeds->delete();
		return Redirect::to('feeds')->with('message', 'Website Deleted!');
	}
	public function getcategory(Request $request){

        if($request->ajax())
        {
           $id = Input::get('catid');
		   if($id!=0){
			   if(Domain_taxonomies::where('domain_id',$id)->where('domain_taxonomy_type','category')->count()>0){
					$txnm=Domain_taxonomies::where('domain_id',$id)->where('domain_taxonomy_type','category')->first();
					$categories = Domain_taxonomies::find($txnm->id)->categories->lists('title','txid');
					return json_encode ($categories);
			   }else{
					$category=Domain_taxonomies::firstOrCreate(['domain_id'=>$id,'domain_taxonomy_type'=>'category']);
					$txnm=Domain_taxonomies::where('domain_id',$id)->where('domain_taxonomy_type','category')->first();
					$txnm_new=Domain_txnm::firstOrCreate(['domain_taxonomies_id'=>$txnm->id,'title'=>'uncategory','txid'=>1]);
					$categories = Domain_taxonomies::find($txnm->id)->categories->lists('title','txid');
					return json_encode ($categories);
			   }

		   }
        }
	}
	/////////////////////////
	public function readfeed($id)
	{
		//
		$domain_feed=Domain_feeds::find($id);
		 $feed = \Feeds::make($domain_feed->domain_feed);
		 $feed->strip_attributes(true);
		$data = array(
		  'title'     => $feed->get_title(),
		  'permalink' => $feed->get_permalink(),
		  'items'     => $feed->get_items(),
		);
		//
		return view('feeds.readfeed',['title'=>'Feeds','feeds'=>$data,'feed'=>$domain_feed]);
	}
	public function single($id){
		$domain=Domain_feeds::find($id);
		return view('feeds.single',['title'=>'Single URL','feed'=>$domain]);
	}
	//////
	public function multi($id){
		$domain=Domain_feeds::find($id);
		return view('feeds.multi',['title'=>'multi URL','feed'=>$domain]);
	}
	//////
	public function edit($id){
			$domain_feed=Domain_feeds::find($id);
			$domains = Domains::all();
			$txnm=Domain_taxonomies::where('domain_id',$domain_feed->domain_id)->where('domain_taxonomy_type','category')->first();
            $categories = Domain_taxonomies::find($txnm->id)->categories->lists('title','txid');
			//$domain_txm=Domain_taxonomies::categories()->where('domain_id',$domain_feed->domain_id)->get();
			///print_r($categories);
			return view('feeds.edit',['title'=>'Edit Feed','feed'=>$domain_feed,'domains'=>$domains,'categories'=>$categories]);
	}
	///////////
	public function update($id,Request $request){
		$data=Domain_feeds::find($id);
		$data->domain_id= $request->input('domain_id');
		$data->domain_category=$request->input('domain_category');
		$data->domain_url=$request->input('domain_url');
		$data->domain_feed= $request->input('domain_feed');
		$data->save();
		//return view('error');
		return Redirect::to('feeds')->with('message', 'Sussessfully Updated! ');
	}
	///////////
	public function readall()
	{
		//
		           // 5 days ago
		  $exitCode = Artisan::call('feed:read');
		 $feed_posts=Feeds::where('feed_state','unread')->orderBy('created_at', 'desc')->take(50)->get();
		 //print_r($feed_posts[0]->created_at);
		 $last_read= Carbon::parse($feed_posts[0]->created_at)->diffForHumans();
		return view('feeds.readall',['title'=>'All feeds','feeds'=>$feed_posts,'last_read'=>$last_read]);
	}

}
