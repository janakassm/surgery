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
	
	public function IsCategory($checkVisible=true)
	{
		$this->CI->db->where('id',$this->id);
		
		$query = $this->CI->db->get('cateogry');
		if($query->num_rows() > 0)
		{	
			/*if($checkVisible && !$this->isActivated())
			{
				return false;
			}*/
			return true;
		}
		else
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
	
	public function Refresh()
	{
		$this->CI->db->where('id',$this->id);
		$query = $this->CI->db->get('cateogry');
		$this->parseToObject($query->row_array());
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