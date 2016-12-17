<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain_fields_tags extends Model {

	//
	 protected $table = 'domain_fields_tags'; 
	 protected $fillable = ['domain_fields_id', 'domain_feed_id','domain_field_tag','type'];
	 
	
}
