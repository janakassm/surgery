<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Category extends GeneralClass {
	
	public		
		$category_id = 0, 
		$category_title_sin = NULL,
		$category_title_eng = NULL,
		$category_parent_id = NULL,
		$category_level = 0,
		$category_visible = false,
		$category_is_deleted = false;
	
		
	public function __construct()
    {
        parent::__construct();
		$this->CI->load->model('Category_Model','category_manager');		
			
	}
	
	public function IsCategory($checkVisible=true, $refreshObject = true)
	{
		 $data = Category_Model::Get($this->category_id,true);
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
		
		$result = Category_Model::GetCategories( $this->category_level, $this->category_id );
		
		if( !empty($result) )	
			return $result;
		
		return false;
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
		return Category_Model::Insert($data);
	}
	
	public function Save()
	{
		$data = $this->GetObjectVars();
		unset($data['category_id']);
		Category_Model::Update($this->category_id, $data);
		return true;
	}
	
	public function Delete()
	{
		Category_Model::Delete($this->category_id);
		return true;
	}
	
	public static function GetCategories($level = NULL, $parent = NULL)
	{
		return Category_Model::GetCategories($level,$parent);
	}
	
}