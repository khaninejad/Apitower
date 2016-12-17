<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

        //
	protected $table = 'posts';
	protected $fillable = ['domain_id','title', 'description', 'source','keywords','thumbnail','custom_fields'];

}