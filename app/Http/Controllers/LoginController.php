<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\LoginPostRequest;
use Hash;
use Redirect;
use App\Users;
use GuzzleHttp\Client;
use Carbon\Carbon;
class LoginController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return view('auth.login',['title'=>'Login']);
	}

	public function login(LoginPostRequest $request){
		 $Users=new Users();
		 $user =  Users::where('email', '=', $request->input('email'))->first();
			if($user!=NULL){
				if (Hash::check($request->input('password'), $user->password)) {
					$userdata=['id'=>$user->id,'username'=>$user->username,'email'=>$user->email];
					session(['user' => $userdata]);
				}else{
					 return Redirect::back()->withErrors(['authentication failed! lets try again']);
				}
			}else{
				return Redirect::back()->withErrors(['authentication failed! lets try again']);
			}
	}
}
