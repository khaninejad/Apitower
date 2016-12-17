<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain_fields extends Model {

	// domain fields modeld
	 protected $table = 'domain_fields'; 
	 protected $fillable = ['domain_id', 'title'];
	 
}
