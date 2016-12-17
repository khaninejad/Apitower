<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CrawlList extends Model {

	//
	protected $table = 'crawl_lists'; 
	protected $fillable = ['domain_id', 'url', 'url_state'];

}
