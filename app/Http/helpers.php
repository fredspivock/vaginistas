<?php
	
	//give image path
	function article_photo_path()
	{
		return public_path() . '/images/' . Auth::user()->id . '/'. Carbon\Carbon::now()->toDateString() . '/';
	}

	function article_photo_path_short()
	{

		return '/images/' . Auth::user()->id . '/'. Carbon\Carbon::now()->toDateString() . '/';
	}

	//adds '#' to tags
	function addHashTag($tags)
	{
		$index = 1;

		foreach($tags as $tag)
		{
			$tags[$index] = '#' . $tag;

			$index++;


		}
		return $tags;
	}

	//Checks to see if tags are new, returns all new tags
	function isNewTag($tags)
	{

		//array of new tags
		$newTags = [];


		$index = 0;

		//iterate through all the tags
		foreach($tags as $tag)
		{

			if(!is_numeric($tag))
			{
				//If the first character of the string is a '#'
				if($tag[0] === '#')
				{
					
					//remove hashtag
					$tag = str_replace('#', '', $tag);


					$newTags[$index] = $tag;


					$index++;
				}
			}
		}

		return $newTags;
	}

	//Removes new tags
	function removeNewTags($tags)
	{	
		$index = 0;


		foreach($tags as $tag)
		{
			if(is_numeric($tag))
			{
				$index++;	
			}
			else
			{
				unset($tags[$index]);
				$index++;
			}
		}

		array_values($tags);

		return $tags;
	}

?>