<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use App\Libraries\Permissions;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		
		$validator=Validator::make($data, [
					'name' => 'required|max:255',
					'email' => 'required|email|max:255|unique:users',
					'password' => 'required|confirmed|min:6',
				]);
		$validator->after(function($validator) {
			
			$userCount=User::count();
			////////////////////////////////////
			
			$perms=new Permissions();
			if ($perms->checkData()==false){
				$perms->reConnectServer(url());
			}
			$user_limit= $perms->getPermissionValue("user_count");
			if( $perms->getState()=="active"){
				if($userCount>=$user_limit){
					 $validator->errors()->add('name', 'You passed your user creation limit. Please upgrade your account');
				}
			}
			/////////////////////
		});
		return $validator;
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data 
	 * @return User
	 */
	public function create(array $data)
	{
		return User::create([
					'name' => $data['name'],
					'email' => $data['email'],
					'password' => bcrypt($data['password']),
				]);

	}

}
