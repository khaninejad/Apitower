<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use App\Domains;
use App\Domain_feeds;
use App\Domain_fields_tags;
use Session;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Libraries\Permissions;
use config;
use App\Feeds;
class HomeController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		//
		$client = new Client();
		$url=urldecode(url());


		 $value = session('user');
		// print_r($data);
		 $domain_count = Domains::all()->count();
		 $feed_count = Domain_feeds::all()->count();
		 $field_count = Domain_fields_tags::whereNotNull('domain_field_tag')->count();
		 $expire_date = Session::get('servicedata');
		 $apitower = config('app.apitower');
		 $expire_time=Carbon::parse($expire_date['user']['subscription_ends_at'])->diffForHumans();
		// print_r($data);
		$uread_feed=Feeds::where('feed_state','unread')->get()->count();
		Session::put('unread_feed', $uread_feed);
		 return view('home.dashboard',['title'=>'Dashboard','domain_count'=>$domain_count,'feed_count'=>$feed_count,'expire_time'=>$expire_time,'field_count'=>$field_count,'plandata'=>str_replace(array(1,"1",'1'), array("Yes"), $data),'apitower'=>$apitower]);
	
	}






}
