<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Http\Requests\IndexSetupUserPostRequest;
use DB;
use Hash;
use App\Users;
use App\Domains;
use Crypt;
use App\Libraries\Wordpress;
use App\Domain_fields; 
use App\Domain_custom_fields; 
use App\Domain_taxonomies;
use App\Domain_txnm;
use App\Domain_feeds;
use App\Domain_fields_tags;
use Illuminate\Http\Request;
use App\Domain_custom_field_tags;
use Redirect;
class SetupController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
/*	public function createuser(IndexSetupUserPostRequest $request)
	{
		//
		 $Users=new Users();
		 $Users->username=$request->input('username');
		 $Users->email=$request->input('email');
		 $Users->password=Hash::make($request->input('password'));
		 $Users->Save();
		 return redirect('login');
		 //return view('setup.user');
	}*/
	
	public function user(){
		return view('setup.user',['title'=>'Setup First User']);
	}
	/*
	 * Store a newly created resource in storage.
	 *
	 * @return Response*/
	 
	public function domain($id){
		$domain = Domains::find($id);

		$endpoint = $domain->domain_endpoint;
		$username=$domain->domain_user;
		$password=Crypt::decrypt($domain->domain_password);


		$word=new Wordpress($endpoint,$username,$password);
		$last=$word->getLastPost();
		if($last['postid']>=1){
			Domain_fields::firstOrCreate(['domain_id'=>$id,'title'=>"title"]);
			Domain_fields::firstOrCreate(['domain_id'=>$id,'title'=>"description"]);
			Domain_fields::firstOrCreate(['domain_id'=>$id,'title'=>"link"]);
			Domain_fields::firstOrCreate(['domain_id'=>$id,'title'=>"mt_keywords"]);
			Domain_fields::firstOrCreate(['domain_id'=>$id,'title'=>"wp_post_thumbnail"]);

			////////////////////////
			/////////////////////// custom field
			foreach($last['custom_fields'] as $item){
				Domain_custom_fields::firstOrCreate(['domain_id'=>$id,'domain_custom_fields_key_id'=>$item['id'],'domain_custom_fields_key'=>$item['key'],'domain_custom_fields_value'=>$item['value']]);				
			}
			$taxonomies=$word->getTaxonomies();
			//print_r($taxonomies);
			foreach($taxonomies as $item){
				$txdata=array('domain_taxonomy_type'=>$item['name'],'domain_id'=>$id);
				$domain_taxonomies = Domain_taxonomies::firstOrCreate($txdata);
				if($item['name']!='post_tag')	{
						$terms=$word->getTerms($item['name']);
						foreach((array)$terms as $term)
						{
							$data=array('domain_taxonomies_id' => $domain_taxonomies->id,'title'=>$term['name'],'txid'=>$term['term_id']);
							$domain_txnm = Domain_txnm::firstOrCreate($data);
						}
						
				}
				
			}
			
			
			//print_r($taxonomies);
			
			
		return Redirect::to('website')->with('message', 'Sussessfully Registered');
			
		}else{
			die ("error" );
		}
	}
	public function tag($id){
		$Domain_feeds = Domain_feeds::find($id);
		
		$Domain_fields=Domain_fields::where('domain_id',$Domain_feeds->domain_id)->get();
		foreach($Domain_fields as $fields){
			$count=Domain_fields_tags::where('domain_fields_id',$fields->id)->where('domain_feed_id',$id)->count();
			if($count<=0){
				$domain_fields_tags=new Domain_fields_tags();
				$domain_fields_tags->domain_fields_id=$fields->id;
				$domain_fields_tags->domain_feed_id=$id;
				$domain_fields_tags->domain_field_tag="";
				$domain_fields_tags->type="tag";
				$domain_fields_tags->Save();
			}
		}
		
		$domain_fields = DB::table('domain_fields_tags')
            ->rightJoin('domain_fields', 'domain_fields_tags.domain_fields_id', '=', 'domain_fields.id')
			->where('domain_id',$Domain_feeds->domain_id)
			->where('domain_feed_id',$id)
            ->get();
			foreach($domain_fields as $item){
					if(is_null($item->type)){
							$domain_fields_tags=new Domain_fields_tags();
							$domain_fields_tags->domain_fields_id=$item->id;
							$domain_fields_tags->domain_feed_id=$id;
							$domain_fields_tags->domain_field_tag="";
							$domain_fields_tags->type="tag";
							$domain_fields_tags->Save();
							
					}
			}
			$domain_custom_fields = DB::table('domain_custom_field_tags')
            ->rightJoin('domain_custom_fields', 'domain_custom_field_tags.domain_custom_fields_id', '=', 'domain_custom_fields.id')
			->where('domain_id',$Domain_feeds->domain_id)
			->where('domain_feed_id',$id)
            ->get();
			if(empty($domain_custom_fields)){
				$domain_custom_fields=Domain_custom_fields::where('domain_id',$Domain_feeds->domain_id)->get();
				foreach($domain_custom_fields as $item){
						Domain_custom_field_tags::firstOrCreate(['domain_custom_fields_id'=>$item->id,'domain_feed_id'=>$id]);
/*									$domain_custom_field_tags=new Domain_custom_field_tags();
									$domain_custom_field_tags->domain_custom_fields_id=$item->id;
									$domain_custom_field_tags->domain_feed_id=$id;
									$domain_custom_field_tags->domain_custom_field_tag="";
									$domain_custom_field_tags->type="tag";
									$domain_custom_field_tags->Save();*/		
					}
			}
			
			$domain_custom_fields = DB::table('domain_custom_field_tags')
            ->rightJoin('domain_custom_fields', 'domain_custom_field_tags.domain_custom_fields_id', '=', 'domain_custom_fields.id')
			->where('domain_id',$Domain_feeds->domain_id)
			->where('domain_feed_id',$id)
            ->get();
	//	

		
		return view('setup.tag',['title'=>'Setup Tag','domain_feeds'=>$Domain_feeds,'domain_fields'=>$domain_fields,'domain_custom_fields'=>$domain_custom_fields]);
	}
	////
	public function storetag(Request $request,$id){
			$Domain_feeds = Domain_feeds::find($id);
		

		$domain_fields = DB::table('domain_fields_tags')
            ->rightJoin('domain_fields', 'domain_fields_tags.domain_fields_id', '=', 'domain_fields.id')
			->where('domain_id',$Domain_feeds->domain_id)
			->where('domain_feed_id',$id)
            ->get();
			foreach($domain_fields as $item){
				$domain_fields_tags = Domain_fields_tags::where('domain_feed_id',$id)->where('domain_fields_id',$item->domain_fields_id)->first();
			//	print_r($domain_fields_tags);
				
					$domain_fields_tags->domain_field_tag=$request->input($item->title);
					$domain_fields_tags->type=$request->input($item->title."_type");
					$domain_fields_tags->Save();
				
			}
			// custom fields
		$domain_custom_fields = DB::table('domain_custom_field_tags')
            ->rightJoin('domain_custom_fields', 'domain_custom_field_tags.domain_custom_fields_id', '=', 'domain_custom_fields.id')
			->where('domain_id',$Domain_feeds->domain_id)
			->where('domain_feed_id',$id)
            ->get();
			foreach($domain_custom_fields as $item){
				$domain_custom_field_tags = Domain_custom_field_tags::where('domain_feed_id',$id)->where('domain_custom_fields_id',$item->domain_custom_fields_id)->first();
				
					$domain_custom_field_tags->domain_custom_field_tag=$request->input($item->domain_custom_fields_key);
					$domain_custom_field_tags->type=$request->input($item->domain_custom_fields_key."_type");
					$domain_custom_field_tags->Save();
				
			}
			////////////////////
			$url=$request->input("url");
			if(strlen($url)>0){
				return Redirect::to('setup/tag/'.$id)->with('message', 'Sussessfully Updated! <a href="'.url().'/post?url='.$url.'&feed='.$id.'&domain='.$Domain_feeds->domain_id.'">Test Data</a>');
			}else{
				return Redirect::to('setup/tag/'.$id)->with('message', 'Sussessfully Updated!');
			}
			//return view('setup.user',['title'=>'Setup Tag']);
	}
	


}
