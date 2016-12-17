<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain_txnm extends Model {

	//
	protected $table = 'domain_txnms'; 
	protected $fillable = ['domain_taxonomies_id', 'title', 'txid'];

	public function txnm(){
		   return $this->belongsTo('App\Domain_taxonomies','domain_taxonomies_id','id');
	}
}
