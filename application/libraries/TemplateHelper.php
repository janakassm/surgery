<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class TemplateHelper extends GeneralClass
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public static function GetCategoryByLevelAsOptions($level=null, $parentId=NUll,$selectedId=false)
	{
		self::$CI->load->library('category');
		
		
		$catList = Category::GetCategories($level,$parentId);
		
		foreach ($catList as $key => $category) 
		{
			$catList[$key]->children = self::TraverseCat($category->category_id,$category->category_level);
		}
		
		
		$html = "";
		$pad = -1;
		$html .= self::GenerateOptionFields( $catList,$pad,$selectedId);
		
		return $html;
	}
	
	private static function GenerateOptionFields($children,&$pad,$selectedId)
	{
		$pad ++;
		
		$frontPad = "";
		for($i=0;$i<($pad*5); $i++)
		{
			$frontPad .= "&nbsp;";
			
		}
		
		
		$html = '';
		foreach ($children as $key => $child) 
		{
			$selectText ="";
			if($selectedId && $child->category_id == $selectedId)
				$selectText=' selected="selected" ';
			
			$html .='<option value="'.$child->category_id.'" '.$selectText.' >'.$frontPad.$child->category_title_sin.'</option>';
			
			if( isset($child->children) )
				$html .= self::GenerateOptionFields($child->children,$pad,$selectedId);
		}
		
		$pad--;
		return $html;
	}
	
	private static function TraverseCat($catId,$level)
	{
		self::$CI->load->library('Category');
		$catList = Category::GetCategories($level,$catId);
		
		foreach ($catList as $key => $category) 
		{
			$catList[$key]->children = self::TraverseCat($category->category_id,$category->category_level);
		}
		
		return $catList; 
	}
	
		
}
