<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class WebsiteStoreRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'domain_title' => 'required|string|min:3',
            'domain_url' => 'required|url',
			'domain_endpoint' => 'required|url',
			'domain_user' => 'required|string',
			'domain_password' => 'required|string'
		];
	}

}
