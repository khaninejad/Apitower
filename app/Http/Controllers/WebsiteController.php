<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteStoreRequest;
use App\Domains;
use Illuminate\Http\Request;
use Crypt;
use Redirect;
use App\Libraries\Permissions;
use Auth;
use App\Domain_custom_fields;
use App\Domain_feeds;
use App\Domain_custom_field_tags;
class WebsiteController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		//
		 $domains = Domains::all();
		// print_r($domains);
		 //die("err");
		return view('website.index',['title'=>'Websites','domains'=>$domains]);
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
		return view('website.create',['title'=>'Create Website','domains'=>$domains]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//

				$domainCount=Domains::count();

				$Domains=Domains::firstOrCreate(['user_id'=>Auth::user()->id,'domain_title'=>$request->input('domain_title'),'domain_url'=>$request->input('domain_url'),'domain_endpoint'=>$request->input('domain_endpoint'),'domain_type'=>$request->input('website_type'),'domain_user'=>$request->input('domain_user'),'domain_password'=>Crypt::encrypt($request->input('domain_password'))]);
					/* $Domains=new Domains();
					 $Domains->user_id=Auth::user()->id;
					 $Domains->domain_title=$request->input('domain_title');
					 $Domains->domain_url=$request->input('domain_url');
					 $Domains->domain_endpoint=$request->input('domain_endpoint');
					 $Domains->domain_type='wordpress';
					 $Domains->domain_user=$request->input('domain_user');
					 $Domains->domain_password=Crypt::encrypt($request->input('domain_password'));
					 $Domains->Save();*/
					 if($request->input('website_type')=="wordpress")
					 return Redirect::to('setup/domain/'. $Domains->id)->with('message', 'Sussessfully Updated!');
					 //return Redirect::to('website')->with('message', 'Sussessfully Updated!');



	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$domain = Domains::find($id);
		return view('website.edit',['title'=>'Edit Website','domain'=>$domain]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(WebsiteStoreRequest $request, $id)
	{
		//
		$domain = Domains::find($id);
		$domain->user_id=Auth::user()->id;
		$domain->domain_title=$request->input('domain_title');
		$domain->domain_url=$request->input('domain_url');
		$domain->domain_endpoint=$request->input('domain_endpoint');
		$domain->domain_type=$request->input('website_type');
		$domain->domain_user=$request->input('domain_user');
		if($request->input('domain_password')!=NULL){
			$domain->domain_password=Crypt::encrypt($request->input('domain_password'));
		}
		$domain->Save();
		return Redirect::to('website')->with('message', 'Sussessfully Updated!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$domain = Domains::find($id);

		$domain->delete();
		return Redirect::to('website')->with('message', 'Website Deleted!');
	}
	public function fields($id)
	{
		$domain_custom_fields = Domain_custom_fields::where('domain_id',$id)->get();
		return view('website.fields',['title'=>'Custom Fields','fields'=>$domain_custom_fields,'domain_id'=>$id]);
	}
	public function fieldedit($id)
	{
		$field = Domain_custom_fields::find($id);
		return view('website.fieldedit',['title'=>'Edit Field','field'=>$field]);
	}
	public function fieldupdate(Request $request,$id)
	{
		$field = Domain_custom_fields::find($id);
		$field->domain_custom_fields_key_id=$request->input('fieldkeyid');
		$field->domain_custom_fields_key=$request->input('fieldkey');
		$field->domain_custom_fields_value=$request->input('fieldvalue');
		$field->Save();
		return Redirect::to('website/fields/'.$field->domain_id)->with('message', 'Sussessfully Updated!');
	//	return view('website.fieldedit',['title'=>'Edit Field','field'=>$field]);
	}
	public function fielddestroy($id)
	{
		$domain_custom_fields = Domain_custom_fields::find($id);
		$domain_id=$domain_custom_fields->domain_id;
		$domain_custom_fields->delete();
		return Redirect::to('website/fields/'.$domain_id)->with('message', 'Field Deleted!');
	}
	public function fieldcreate($id)
	{
		//
		//$domains = Domains::all();
		return view('website.fieldcreate',['title'=>'Create Field','domain_id'=>$id]);
	}
	public function fieldstore(Request $request,$id)
	{
		$domain_custom_fields=Domain_custom_fields::firstOrCreate(['domain_id'=>$id,'domain_custom_fields_key_id'=>$request->input('fieldkeyid'),'domain_custom_fields_key'=>$request->input('fieldkey'),'domain_custom_fields_value'=>$request->input('fieldvalue')]);
		$domain_feeds=Domain_feeds::where('domain_id',$id)->get();
		foreach($domain_feeds as $feed){
		$domain_custom_field_tags=Domain_custom_field_tags::firstOrCreate(['domain_custom_fields_id'=>$domain_custom_fields->id,'domain_feed_id'=>$feed->id,'domain_custom_field_tag'=>'','type'=>'value']);
		}
					return Redirect::to('website/fields/'.$id)->with('message', 'Sussessfully created!');
	}

}
