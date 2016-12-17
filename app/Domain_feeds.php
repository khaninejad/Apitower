<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain_feeds extends Model {

	//
	 protected $table = 'domain_feeds'; 
	 protected $fillable = ['domain_id', 'domain_category', 'domain_url', 'domain_feed'];
	 
	 
	  public function feeds(){
        return $this->hasMany('App\Feeds');
	  }
	  public function latestFeed(){
	 	 return $this->hasOne('App\Feeds')->latest();
	}
}
