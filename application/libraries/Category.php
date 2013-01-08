<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Category extends GeneralClass {
	
	public		
		$category_id = 0, 
		$category_title_sin = NULL,
		$category_title_eng = NULL,
		$category_parent_id = 0,
		$category_visible = false;
	
		
	public function __construct()
    {
        parent::__construct();
		$this->CI->load->model('category_model','category_manager');		
			
	}
	
	public function IsCategory($checkVisible=true, $refreshObject = true)
	{
		 $data = $this->CI->category_manager->Get($this->category_id,true);
		 if( !empty($data) )
		 {
		 	if($refreshObject)
				$this->Refresh($data);
			
			return true;
		 }
		 
		 return false;
	}
	
	public function IsVisible()
	{
		return false;
	}
	
	public function GetPatrentDetails()
	{
		if( is_null($this->category_parent_id) )
			return NULL;
		
		return Category_Model::Get( $this->category_parent_id );
	}
	
	public function GetChildCategories()
	{
		if( is_null($this->category_id) )
			return NULL;
		
		return Category_Model::GetCategories( NULL, $this->category_id );	
	}
	
	/* General functions */
	
	public function Refresh($data = NULL)
	{
		if( is_null($data) )
			$data = $this->CI->category_manager->Get($this->category_id,true);
		
		$this->parseToObject($data);
	}
	
	
	public function Register()
	{
		$data = $this->GetObjectVars();
		$this->CI->category_manager->Insert($data);
	}
	
	public static function GetCategories($level = NULL, $parent = NULL)
	{
		return Category_Model::GetCategories($level,$parent);
	}
	
}