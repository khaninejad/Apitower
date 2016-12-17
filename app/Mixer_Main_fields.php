<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Mixer_Main_fields extends Model {

     protected $table = 'mixer__main_fields'; 
	 protected $fillable = ['feed_id','domain_field_id', 'postfix','type','field_tag'];

}