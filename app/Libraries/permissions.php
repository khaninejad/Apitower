<?php 
namespace App\Libraries;
use Session;
use GuzzleHttp\Client;
use Carbon\Carbon;
 class Permissions {
	protected $serverData=array();
	public function __construct(){
		$this->serverData = Session::get('servicedata');
	} 
	public function reConnectServer($url){
		$client = new Client();
		$url=urldecode($url);
		 try {
			$response=$client->post('http://apitower.com/service/getdata', [
			'body' => [
				'serviceurl' => $url
			]
		]);
			if($response->getStatusCode()==200){
				$data = $response->json();
				$this->serverData=$data;
				Session::put('servicedata', $data);
				return $data;
			}
		 } catch (\GuzzleHttp\Exception\ClientException $e){
		 	echo 'Caught response: ' . $e->getResponse()->getStatusCode();
		 }catch (\GuzzleHttp\Exception\ServerException $e){
		 	echo 'error response: ' . $e->getResponse()->getStatusCode();
		 }
	}
	public function checkData(){
		if (Session::has('servicedata')){
			return true;
		}else{
			return false;
		}
	}
	public function getState(){
		return $this->serverData['client']['state'];
	}
	public function getPermissionValue($permission){
		foreach($this->serverData['permissions'] as $perms){
			if($perms['name']==$permission)
			return $perms['value'];
		}
		return false;	
	}
	public function checkPermission($permission){
		foreach($this->serverData['permissions'] as $perms){
			if($perms['name']==$permission)
			return true;
		}
		return false;
	}
 }
 
  ?>