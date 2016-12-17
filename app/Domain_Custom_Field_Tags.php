<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain_custom_field_tags extends Model {

	//
	 protected $table = 'domain_custom_field_tags'; 
	 protected $fillable = ['domain_custom_fields_id', 'domain_feed_id','domain_custom_field_tag','type'];

}
