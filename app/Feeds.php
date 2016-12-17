<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Feeds extends Model {

        //
	protected $table = 'feeds';
	protected $fillable = ['feeds_id','feed_title', 'feed_url', 'feed_description','feed_state'];
	
	public function domain(){
		   return $this->belongsTo('App\Domain_feeds','feeds_id','id');
	}
	
}