<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DB;
use Hash;
use Crypt;
use App\Libraries\Wordpress;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;
use App\Libraries\KeywordGenerate;
use App\Domains;
use App\Domain_custom_fields;
use App\Domain_fields;
use Redirect;
use Session;
use App\Libraries\Permissions;
use App\Mixer_Main_fields;
use App\Post;
use Excel;
use App\Domain_taxonomies;
use App\Domain_txnm;
class PostController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}
	public function index(Request $request)
	{
		//
		$url=$request->input('url');
		$feed_id = $request->input('feed');
		$domain_id = $request->input('domain');
		$single = $request->input('single');
		$client = new Client();

		$crawler = $client->request('GET', urldecode($url));
		$status_code = $client->getResponse()->getStatus();
		if($status_code==404){
			return view('post.notfound',['title'=>'Post not found','url'=>$url,'feed_id'=>$feed_id]);
		}

		$domain_fields = DB::table('domain_fields_tags')
            ->rightJoin('domain_fields', 'domain_fields_tags.domain_fields_id', '=', 'domain_fields.id')
			->where('domain_id', $domain_id)
			->where('domain_feed_id',$feed_id)
            ->get();
			$main_data=array();
			$customfield_data=array();
			//print_r($domain_fields);
			$main_feild_count=count($domain_fields);
			foreach($domain_fields as $item){
					$mixer=Mixer_Main_fields::where('domain_field_id',$item->id)->where("feed_id",$feed_id )->get();
					$out_value="";
					//print_r($mixer);
					if (count($mixer)){
						foreach($mixer as $mixitem)
						if($mixitem->postfix=="before"){
							if($mixitem->type=="tag"){
								$out_value.=$crawler->filter($mixitem->field_tag)->html();
							}else{
								$out_value.=$mixitem->field_tag;
							}
						}
					}
					if($item->type=="tag"){
						if($item->title=="title"){
							$count=$crawler->filter($item->domain_field_tag)->count();
							if($count>0){
								$out_value.=$crawler->filter($item->domain_field_tag)->text();
							}else{
								$out_value.="";
							}
						}else
						if($item->title=="description"){
							$count=$crawler->filter($item->domain_field_tag)->count();
							if($count>0){
							    $out_value.=$crawler->filter($item->domain_field_tag)->html();
							}else{
								$out_value.="";
							}


						}else
						if($item->title=="link"){
							$count=$crawler->filter($item->domain_field_tag)->count();
							if($count>0){
								$temp=$crawler->filter($item->domain_field_tag)->attr('href');
								if(strlen($temp)<0){
									$out_value.=$crawler->filter($item->domain_field_tag)->attr('content');
								}else{
									$out_value.=$temp;
								}
							}else{
								$out_value.="";
							}
						}else
						if($item->title=="mt_keywords"){
							$count=$crawler->filter($item->domain_field_tag)->count();
							if($count>0){
							$out_value.=$this->generate_keywords($crawler->filter($item->domain_field_tag)->text());
							}else{
								$out_value.="";
							}
						}else
						if($item->title=="wp_post_thumbnail"){
							$count=$crawler->filter($item->domain_field_tag)->count();
							if($count>0){
								$temp=$crawler->filter($item->domain_field_tag)->attr('src');
									if(starts_with($temp,'//')){
										$out_value.="http:".$item->domain_field_tag;
									}else{
										$out_value.=$temp;
									}

							}else{
								$out_value.="";
							}
						}

					}
				//	echo count($mixer)."<br/>";
					if (count($mixer)>=1){
						foreach($mixer as $mixitem)
						if($mixitem->postfix=="after"){
							if($mixitem->type=="tag"){
								$count=$crawler->filter($mixitem->field_tag)->count();
								if($count>0){
									$out_value.=$crawler->filter($mixitem->field_tag)->html();
								}
							}else{
								$out_value.=$mixitem->field_tag;
							}
						}
					}
					array_push($main_data,['title'=>$item->title,'type'=>$item->type,'value'=>$out_value]);


			///////
			}
			//print_r($main_data);
			$main_data=$this->replace_tags($main_data);
			//print_r($main_data);
			$domain_custom_fields = DB::table('domain_custom_field_tags')
            ->rightJoin('domain_custom_fields', 'domain_custom_field_tags.domain_custom_fields_id', '=', 'domain_custom_fields.id')
			->where('domain_id', $request->input('domain'))
			->where('domain_feed_id',$request->input('feed'))
            ->get();
			if(count($domain_fields)<=0 && count($domain_custom_fields)<=0 && $single!="true")
				return view('post.nofield',['title'=>'Post New','url'=>$url,'feed_id'=>$feed_id]);
			foreach($domain_custom_fields as $item){
					if($item->type=="tag"){
							$count=$crawler->filter($item->domain_custom_field_tag)->count();
							if($count>0){
								$item->domain_custom_field_tag=$crawler->filter($item->domain_custom_field_tag)->text();
							}else{
								$item->domain_custom_field_tag="";
							}
					}
					array_push($customfield_data,['title'=>$item->domain_custom_fields_key,'type'=>$item->type,'value'=>$item->domain_custom_field_tag]);
			}
			////////


			//print_r($customfield_data);



			$domain = Domains::find($domain_id);
			$endpoint = $domain->domain_endpoint;
			$username=$domain->domain_user;
			$password=Crypt::decrypt($domain->domain_password);
			$cats=array();

				$txnm=Domain_taxonomies::where('domain_id',$domain_id)->where('domain_taxonomy_type','category')->first();
				$cats = Domain_taxonomies::find($txnm->id)->categories;
				//dd($cats);



		return view('post.index',['title'=>'Post New','post_data'=>json_decode(json_encode($main_data)),'post_category'=>json_decode(json_encode($cats)),'custom_fields'=>json_decode(json_encode($customfield_data)),'domain_id'=>$domain_id,'feed_id'=>$feed_id,'url'=>$url]);

	}
/////////////////////

	private function generate_keywords($content){
	$keyword=new KeywordGenerate(trim(strip_tags( $content)));
			$level1=$keyword->rateKeyword(1);
			$level2=$keyword->levelTwo($level1);
			$level=array();
			$count=0;
			foreach($level1 as $key=>$value){
				if($count<=20){
					array_push($level,$key);
					$count++;
				}else{
					break;
				}
			}
			$merge=array_merge($level,$level2);
			$keystr=implode(",",$merge);
			return $keystr;
	}
	public function multi(Request $request)
	{
		$feed_id = $request->input('feed');
		$domain_id = $request->input('domain');
		$url = $request->input('url');
		//print_r(	$request->input('url'));
		$textAr = explode("\n", $url);
		$textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind

		foreach ($textAr as $line) {
		  echo '<a href="'.url().'/post?domain=9&feed=106&single=true&url='.$line.'">'.$line.'</a><br/>';
		}
	}
	///////
	public function publish($id, Request $request)
	{
		$post_title=$this->check_null($request->input('title'));
		$post_content=$this->check_null($request->input('description'));
		$post_link=$this->check_null($request->input('link'));
		$keywords=$this->check_null($request->input('mt_keywords'));
		$cat_name=$request->input('post_category');
		if(count($cat_name)<=0)
		$cat_name=NULL;
		//print_r($cat_name);
		$tags=explode(",",$keywords);
		//print_r($tags);
		$thumbnail=$this->check_null($request->input('wp_post_thumbnail'));


		$custom_domain=Domain_custom_fields::where('domain_id',$id)->get();
		$custom_field=array();
		foreach($custom_domain as $item){
			if(isset($_POST[$item['domain_custom_fields_key']]))	{
				$custom_field[]=array('key' => $item['domain_custom_fields_key'],'value'=>$request->input($item['domain_custom_fields_key']));

			}
		}

		$domain = Domains::find($id);

		$endpoint = $domain->domain_endpoint;
		$username=$domain->domain_user;
		$password=Crypt::decrypt($domain->domain_password);
		$perms=new Permissions();
			if ($perms->checkData()==false){
				$perms->reConnectServer(url());
			}
			//echo $perms->getState();
			if( $perms->getState()=="active"){
				$ads_display= $perms->getPermissionValue("ads_display");
				if($domain->domain_type=="wordpress"){
					if($ads_display==1){
						$ads=['<br/>Data Extract by <a href="https://apitower.com">Apitower</a>','free <br/><a href="https://apitower.com"> wordpress data extractor</a>','<br/>free<a href="https://apitower.com"> web data miner</a>','<br/>free<a href="https://apitower.com"> data migration</a>','<br/>free<a href="https://apitower.com"> news watcher</a>','<br/>free<a href="https://apitower.com"> website migration</a>'];
						$rand=rand(0,5);
						$post_content.=$ads[$rand];
					}

					$word=new Wordpress($endpoint,$username,$password);
					$post_id=$word->createPost($post_title,stripslashes ($post_content),$cat_name,$tags,$thumbnail,$custom_field);
				}else {
					$client = new Client();
					 try {
						 $parametrs=[
							'username'=>$username,
							'password'=>$password,
							'custom_fields'=>$custom_field
						];
					    $client->request('POST', urldecode($endpoint),$parametrs);
						$status_code = $client->getResponse()->getStatus();
						if($status_code==404){
							return Redirect::back()->with('error','Endpoint Not Found: '.$endpoint);
							//echo "endpoint not found"	;
						}
						 } catch (\GuzzleHttp\Exception\ClientException $e){
							 print_r($e->getResponse());
							echo 'Caught err: ' . $e->getResponse()->getStatusCode();
						 }catch (\GuzzleHttp\Exception\ServerException $e){
							echo 'error response: ' . $e->getResponse()->getStatusCode();
						 }
				}
				if($post_title=="null")
				$post_link=str_random(20);

				$post=Post::create(
				[
				'domain_id'=>$id,
				'title'=>$post_title,
				'description'=>stripslashes ($post_content),
				'source'=>$post_link,
				'keywords'=>$keywords,
				'thumbnail'=>$thumbnail,
				'custom_fields'=>json_encode($custom_field)
				]);
			////	print_r($post);
				if(isset($post_id))
				return Redirect::back()->with('message','Operation Published! <a href="'.$domain->domain_url.'/?p='.$post_id.'">View Post</a>');
				return Redirect::back()->with('message','Operation Published!');
			}
		//echo "post_id".$post_id;
		}
		/////////////////////
		public function test(){
			$domain = Domains::find(1);

			$endpoint = $domain->domain_endpoint;
			$username=$domain->domain_user;
			$password=Crypt::decrypt($domain->domain_password);
			$word=new Wordpress($endpoint,$username,$password);
			$image=$word->upload_thumbnail("http://placehold.it/350x150",rand(1,10)."test.jpg");
			print_r($image);
		}
		public function filterdomain(){
			$domains = Domains::all();
			return view('post.domain',['title'=>'Posts','domains'=>$domains]);
		}
		public function postlist(Request $request){
			$domain_id=$request->input('filter_domain');
			$posts = Post::where('domain_id',$domain_id)->get();
			return view('post.postlist',['title'=>'Posts','posts'=>$posts,'domain_id'=>$domain_id]);
		}

		public function export($id){
					if(isset($id)){
						$domain_fields=Domain_fields::where('domain_id',$id)->lists('title');
						$domain_custom_fields=Domain_custom_fields::where('domain_id',$id)->lists('domain_custom_fields_key');

						Excel::create('Export-'.date("Y-m-d h:i:s"), function($excel) use($domain_fields,$domain_custom_fields,$id) {

						$excel->sheet('Posts', function($sheet)  use($domain_fields,$domain_custom_fields,$id) {
							$posts = Post::where('domain_id',$id)->get();

							$sheet->setOrientation('landscape');
						//	$header=['ID','Title','Description','Source','Keywords','Thumbnail','more'];
							$sheet->fromArray($domain_fields);
							$sheet->fromArray($domain_custom_fields);

							$i=2;
							$j=0;
							foreach($posts as $post){
								//print_r($post);
								//echo $post->title."<br/>";
								$custom_json=json_decode($post->custom_fields);
								$array_main=array();//
								  foreach($custom_json as $custom){
								//	 print_r($custom);
								//	echo "<br/>";
									 // $sheet->appendRow($i, array($custom->value));
									 if(strlen($custom->value)>=1){
										 $array_main[$j]=$custom->value;
									 }else{
											$array_main[$j]="null";
									 }
									 //array_push($array_main,$custom->value);
									//echo $custom->value;

								$j++;
								  }
								  $array_main=array_values($array_main);
							//	print_r($array_main);
							//	echo "<br/>";
						$out=array_merge(array(
						$this->check_null($post->title),$this->check_null($post->description),$this->check_null($post->source),$this->check_null($post->keywords),$this->check_null($post->thumbnail)), $array_main);
								 $sheet->appendRow($i,$out);
							 $i++;
							}
						});
						})->export('xls');;

		}
		private function check_null($data){
			if($data==""){
				return "null";
			}else{
				return $data;
			}

		}
		private function replace_tags($array){
			//print_r($array);
				foreach($array as $key => $val){
					$count_start=substr_count($array[$key]['value'],"{{");
					//echo $count_start;
					for($i=0;$i<$count_start;$i++){
						$parsed = $this->get_string_between($array[$key]['value'], '{{', '}}');
						if(strlen($parsed)>0){
							//echo "{{".$parsed."}}";
							$new_str=$this->find_array($array,$parsed);
							//echo "source:".$new_str;
							$str_replace='{{'.$parsed.'}}';
							$array[$key]['value']=str_replace($str_replace,$new_str,$array[$key]['value']);
							//echo $item['value'];
						}
					}
				}
				//print_r($array);
				return $array;
		}
		private function find_array($array,$val){
			foreach($array as $item){
				if($item['title']==$val)
				return $item['value'];
			}
		}
	private function get_string_between($string, $start, $end){
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

}
