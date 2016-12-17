<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain_custom_fields extends Model {

	//
	 protected $table = 'domain_custom_fields'; 
	 protected $fillable = ['domain_id', 'domain_custom_fields_key_id', 'domain_custom_fields_key', 'domain_custom_fields_value'];

}
