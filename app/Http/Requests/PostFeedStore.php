<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostFeedStore extends Request {

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
			'domain_id' => 'required|integer',
            'domain_category' => 'required|integer',
			'domain_url' => 'required|url',
			'domain_feed' => 'url'
		];
	}

}
