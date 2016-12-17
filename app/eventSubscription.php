<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class eventSubscription extends Model {

	//
	protected $table = 'event_subscriptions'; 
	protected $fillable = ['user_id', 'event_name', 'event_type','trigged','period','state'];
}
