<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Domains;
use App\Domain_taxonomies;
use App\Domain_fields;
use App\Mixer_Main_fields;
use Redirect;
use App\Libraries\Permissions;
use App\Domain_feeds;
class MixerController extends Controller {

		public function __construct()
		{
			$this->middleware('auth');
		}

        public function index()
        {
				$mixer_main=Mixer_Main_fields::all();
                return view('mixer.index',['title'=>'Field mixer','mixer_main'=>$mixer_main]);
        }
		public function fields(){

		}
		public function fieldadd(){

					$domains = Domains::all();
					return view('mixer.fieldadd',['title'=>'Field add','domains'=>$domains]);

			
		}
		public function fieldstore(Request $request){
			 $this->validate($request, [
      	 	 'field_id' => 'required',
			 'feed_id' => 'required',
     		 'field_positon' => 'required',
			 'mixer_field_type' => 'required',
			 'mixer_field_value' => 'required'
		    ]);
			Mixer_Main_fields::firstOrCreate(['feed_id'=>$request->input('feed_id'),'domain_field_id'=>$request->input('field_id'),'postfix'=>$request->input('field_positon'),'type'=>$request->input('mixer_field_type'),'field_tag'=>$request->input('mixer_field_value')]);
			return Redirect::to('mixer')->with('message', 'Sussessfully Created!');

		}
		public function getfields(Request $request){

        if($request->ajax())
        {
           $id = $request->input('domain_id');
		   if($id!=0){
			$domain_fields=Domain_fields::where('domain_id',$id)->get()->lists('id','title');
//            $categories = Domain_taxonomies::find($txnm->id)->categories->lists('title','txid');
			//print_r($categories);//
			return json_encode ($domain_fields);
		   }
        }

	}
	public function getfeeds(Request $request){

        if($request->ajax())
        {
           $id = $request->input('domain_id');
		   if($id!=0){
			$domain_fields=Domain_feeds::where('domain_id',$id)->get()->lists('id','domain_url');
//            $categories = Domain_taxonomies::find($txnm->id)->categories->lists('title','txid');
			//print_r($categories);//
			return json_encode ($domain_fields);
		   }
        }

	}
	public function destroy($id){

        $Mixer_Main_fields = Mixer_Main_fields::find($id);
		$Mixer_Main_fields->delete();
		return Redirect::to('mixer')->with('message', 'mixeer Deleted!');
		}

}
