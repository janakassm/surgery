<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class SearchUri {
	private $CI;
	private $filters;
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function GetUrl($currentURL, $without=NULL)
	{
		$URIArray = $this->CI->uri->ruri_to_assoc();
		if(!is_null($without))
		{
			if(is_array($without))
			{
				foreach($without as $wi)
					unset($URIArray[$wi]);
			}
			else
				unset($URIArray[$without]);
		}
		
		//remove unwanted filters. Note: $filters must set first using SetFilters()
		if(!empty($this->filters))
		{
			foreach($URIArray as $key=>$val)
			{
				if(!in_array($key,$this->filters))
					unset($URIArray[$key]);
				//var_dump(empty($val));
				if(empty($val))
					unset($URIArray[$key]);
			}
		}
			
		if(!empty($URIArray))
			$stringFix = "/";
			
		return $currentURL.$this->CI->uri->assoc_to_uri($URIArray).@$stringFix;
	}
	
	public function SetFilters($filters=array())
	{
		if(!is_array($filters))
			return false;
		$this->filters = $filters;
	}
}