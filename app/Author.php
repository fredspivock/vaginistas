<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model {

	//Massassignable
	protected $fillable =[
		'profile',
		'image_path',
		'user_id',
	];

	//User relationshiop
	public function User()
	{
		$this->belongsTo('App/User');
	}




}
