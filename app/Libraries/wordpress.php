<?php 
namespace App\Libraries;
use App\Libraries\IXR_Client;
 class Wordpress {
	  public $user;
	  public $pass;
	  public $blog;
	 public function __construct($blog, $user, $pass)
	  {
		$this->blog = $blog;
		$this->user = $user;
		$this->pass = $pass;
	} 
	//////////////////////////
	public function getLastPost(){
	$client = new IXR_Client($this->blog);
	$filter = array(
     'sticky' => true,
	 'number'=>1,
	 'order' =>'DESK',
     'post_type' => 'post',
     'post_status' => 'publish'
);
	if (!$client->query('wp.getPosts','', $this->user,$this->pass,$filter)){  
 	   echo('Error occured during getting post.' . $client->getErrorCode().":".$client->getErrorMessage());  
        }else{
		  $post = $client->getResponse();
		  if(isset($post[0])){
			  $post=$this->getBlogPost($post[0]['post_id']);
			  return $post;
		  }else{
				echo "no post found "  ;
		  }
		}
	}
	/////////////////////////
	function getBlogPost($post_id){
		$client = new IXR_Client($this->blog);
		 if (!$client->query('metaWeblog.getPost',$post_id, $this->user,$this->pass))
        {  
            echo('Error occured during getting post.' . $client->getErrorCode().":".$client->getErrorMessage());  
        }
        $post = $client->getResponse();
       return $post;
	}
	////////////////////////
	function getTaxonomies(){
		 $client=new IXR_Client($this->blog);
		 try{
			 if (!$client->query('wp.getTaxonomies','', $this->user,$this->pass))
			{  
				echo('Error occured during getpoststate request.' . $client->getErrorCode().":".$client->getErrorMessage());  
			}
			$cats = $client->getResponse();
		   
			if(!empty($cats))
			{
			   return $cats;
			}
		} catch (Exception $e) {
			 echo 'Caught exception: ',  $e->getMessage(), "\n";
		 }
	}
	///////////////////////////
	function getTaxonomy($type){
		 $client=new IXR_Client($this->blog);
		 try{
			 if (!$client->query('wp.getTaxonomy','', $this->user,$this->pass,$type))
			{  
				echo('Error occured during category request.' . $client->getErrorCode().":".$client->getErrorMessage());  
			}
			$cats = $client->getResponse();
		   
			if(!empty($cats))
			{
			   return $cats;
			}
		} catch (Exception $e) {
			 echo 'Caught exception: ',  $e->getMessage(), "\n";
		 }
	}
	/////////////////////
	function getTerms($type){
		 $client=new IXR_Client($this->blog);
		 try{
			 if (!$client->query('wp.getTerms','', $this->user,$this->pass,$type))
			{  
				echo('Error occured during category request.' . $client->getErrorCode().":".$client->getErrorMessage());  
			}
			$cats = $client->getResponse();
		   
			if(!empty($cats))
			{
			   return $cats;
			}
		} catch (Exception $e) {
			 echo 'Caught exception: ',  $e->getMessage(), "\n";
		 }
	}
	function getCategoryList(){
		 $client=new IXR_Client($this->blog);
		 try{
			 if (!$client->query('wp.getCategories','', $this->user,$this->pass))
			{  
				return $client->getErrorCode();
			}
			$cats = $client->getResponse();
		   
			if(!empty($cats))
			{
			   return $cats;
			}
		} catch (Exception $e) {
			 echo 'Caught exception: ',  $e->getMessage(), "\n";
		 }
	}
	///////////////////////////
	function createPost($title,$postcontent,$cat_array,$tags,$thumbnail=NULL,$custom_fields){
		$client=new IXR_Client($this->blog);
	    $content['title'] = $title;
        $content['categories'] = $cat_array;
        $content['description'] = $postcontent;
        $content['custom_fields'] =$custom_fields;
        $content['mt_keywords'] = $tags;
		if($thumbnail!=NULL){
			$filename = substr(strtolower(trim(preg_replace('#\W+#', '_', $thumbnail), '_')),-20);
			$imageid=$this->upload_thumbnail($thumbnail,$filename.".jpg");
			if($imageid)
			$content['wp_post_thumbnail'] = $imageid['id'];
		}
		
		
		
       
        if (!$client->query('metaWeblog.newPost','', $this->user,$this->pass, $content, true))
        {
            die( 'Error while creating a new post' . $client->getErrorCode() ." : ". $client->getErrorMessage());  
        }
        $ID =  $client->getResponse();
       
        if($ID)
        {
           $blog=str_replace("xmlrpc.php","?p=".$ID,$this->blog);
           return $ID;
        }
	}
	/////////////////////////////////
		function upload_thumbnail($url,$filename){
		$client=new IXR_Client($this->blog);
		//$client->debug=true;
		//$client->message=true;
		if(function_exists('file_get_contents')) {
			if($url!='null'){
			$bits=new IXR_Base64(file_get_contents($url));
			$image = array(
				'name'  => $filename,
				'type'  => 'image/jpg',
				'bits' => $bits,
				'overwrite' => 0);
			//print_r($image);
			
			if (!$client->query('wp.uploadFile',1, $this->user,$this->pass, $image, true))
			{
				die( 'Error while creating a new post' . $client->getErrorCode() ." : ". $client->getErrorMessage());  
			}
			$ID =  $client->getResponse();
			//print_r( $ID);
			return $ID;
		}else{
			return false;	
		}
		
		}
	
	}
 }
 
  ?>