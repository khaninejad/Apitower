<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use DB;
class IndexSetupUserPostRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		$users = DB::table('users')->count();
		if($users>=1){
			return false;
		}else{
			return true;	
		}
		
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
			'password_confirmation' => 'required|min:6|same:password'
		];
	}

}
