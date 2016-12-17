<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Domains;
use config;
class ServiceController extends Controller {

        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
      public function getdata(Request $request){
		$users=User::all();
		$domains=Domains::all();
		//Symfony\Component\HttpFoundation\Request::trustProxyData();
		$agent=$_SERVER['HTTP_USER_AGENT'];
		if($agent=="Apitower/Guzzel"){
			return response()->json(['agent'=>$_SERVER['HTTP_USER_AGENT'],'version'=>config('app.apitower'),'users' => $users,'domains'=>$domains]);
		}else{
				return response()->json(['error'=>'Error #1']);
		}
	}
}
