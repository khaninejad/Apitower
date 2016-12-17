<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Request;
use App\User;
use Redirect;
class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	 protected $redirectPath = '/';
	public function __construct(Guard $auth, Registrar $registrar)
	{

		
		$this->auth = $auth;
		$this->registrar = $registrar;
		//$this->middleware('connectToServer');
		if (Request::is('auth/register')) {
			$userCount=User::count();
			if($userCount!=0 && $this->auth-> guest()){
		 	  $this->middleware('auth');
			}
		}
		
		
		
	}
	public function getLogin(){
		$userCount=User::count();
		if($userCount<=0){
			return Redirect::to('auth/register')->with('error', 'Please create your account before you can use it');	
		}else{
			return view('auth.login',['title'=>'Login']);
		}
		
	}

}
