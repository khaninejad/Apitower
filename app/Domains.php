<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Domains extends Model {

	//
	 protected $table = 'domains'; 
	 protected $fillable = ['user_id', 'domain_title', 'domain_url','domain_endpoint','domain_type','domain_user','domain_password'];
	 
	
protected $hidden = ['domain_password', 'domain_user'];
}
