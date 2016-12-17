<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\CrawlList;

use Guzzle\Http\Client;
use Symfony\Component\DomCrawler\Crawler;
use Storage;
use App\Domain_feeds;
use App\Domain_fields; 
use App\Domain_custom_fields; 
use App\Domain_fields_tags;
use App\Domain_custom_field_tags;
use DB;
class CrawlerController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	 public function __construct()
	{
		$this->middleware('auth');
	}
	public function index()
	{
		//
	}

	public function extractdata($id){
		return view('crawler.extractdata',['title'=>'Extract data','domain_id'=>9]);	
	}
	public function queuedata(Request $request,$id){
		$url_count=CrawlList::where('domain_id',$id)->get()->count();
		if($url_count>=100){
			die("big than 100");
		}else{
			
			$urls = $request->input('urls');
			$url_all = explode("\n", $urls);
			print_r($url_all);
			foreach($url_all as $item){
				$item=trim($item);
				if (filter_var($item, FILTER_VALIDATE_URL)) { 
					//echo  $item."valid<br/>";
					$url=CrawlList::firstOrCreate(['domain_id'=>$id,'url'=>$item,'url_state'=>'unprocessed']);
				}else{
					echo  $item."invalid<br/>";	
				}
				
			}
			//print_r($your_array);
		}
	}
	public function viewoutput(){
		if (Storage::exists('output.html'))
		{
			$contents = Storage::get('output.html');
			echo $contents;
		}	
	}
	public function tag(Request $request,$id){
		$url=$request->input('url');
		$client = new \GuzzleHttp\Client();
		 try {
			$response = $client->get($url);

			$body=$response->getBody();
			//$body= $this->strip_single("script",$body);
			//$crawler = new Crawler($body);
			$body=str_replace("</body>",'<script src="'.url().'/js/marking.js" type="text/javascript"></script></body>',$body);
			$body=str_replace('<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>','',$body);
			Storage::disk('local')->put('output.html', $body);
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
					}
			}
			
			$domain_custom_fields = DB::table('domain_custom_field_tags')
            ->rightJoin('domain_custom_fields', 'domain_custom_field_tags.domain_custom_fields_id', '=', 'domain_custom_fields.id')
			->where('domain_id',$Domain_feeds->domain_id)
			->where('domain_feed_id',$id)
            ->get();
			return view('crawler.viewtag',['title'=>'Tag Data','domain_feeds'=>$Domain_feeds,'domain_fields'=>$domain_fields,'domain_custom_fields'=>$domain_custom_fields,'url'=>$url]);
			
		 } catch (\GuzzleHttp\Exception\ClientException $e){
		 	echo 'Caught response: ' . $e->getResponse()->getStatusCode();
		 }catch (\GuzzleHttp\Exception\ServerException $e){
		 	echo 'error response: ' . $e->getResponse()->getStatusCode();
		 }
		
	}
	 function strip_single($tag,$string){
    $string=preg_replace('/<'.$tag.'[^>]*>/i', '', $string);
    $string=preg_replace('/<\/'.$tag.'>/i', '', $string);
    return $string;
  } 


}
