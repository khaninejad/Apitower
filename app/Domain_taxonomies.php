<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain_taxonomies extends Model {

	// let's go
	 protected $table = 'domain_taxonomies'; 
	 protected $fillable = ['domain_id', 'domain_taxonomy_type'];
	 
	public function categories()
    {
        return $this->hasMany('App\Domain_txnm');
    }
}
