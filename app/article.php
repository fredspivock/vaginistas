<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class article extends Model {

	//Make the following mass assignable
	protected $fillable = 
		[
			'title',
			'body', 
			'published_at',
			'image_path'

		];

		public function setPublishedAtAttribute($date)
		{

			//if the date is later than now, set the time to midnight if not set it to current time
			if($date >= Carbon::now())
			{

				$this->attributes['published_at'] = Carbon::parse($date);
			}
			else
			{
				$this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d', $date);
			}
			
		}

		//published not in the future
		public function scopePublished($query)
		{
			$query->where('published_at', '<=', Carbon::now());
		}

		public function scopeUnPublished($query)
		{
			$query->where('published_at', '>=', Carbon::now());
		}

		public function scopePublishedAtDesc($query)
		{
			$query->orderBy('published_at', 'desc');
		}

		//publish in ascending order
		public function scopePublishedAtAsc($query)
		{
			$query->orderBy('published_at', 'asc');
		}


		/*
		* Relationship between  users and articles
		*/

		public function User()
		{
			return $this->belongsTo('App\User');
		}

		/*
		*Relationship between tags and articles
		*/
		public function tags()
		{
			return $this->belongsToMany('App\Tag');
		}

		/*
		* Returns Tag List
		*/
		public function getTagListAttribute()
		{
			return $this->tags->lists('id');
		}

		public function getDates()
		{
    		// only this field will be converted to Carbon
    		return array('updated_at', 'published_at', 'created_at');
		}


}
