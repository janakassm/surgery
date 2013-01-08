<?php
class Category_model extends CI_Model {
	
	private static $table = "category";
	protected static $ci;
	protected static $db;
	
	public function __construct()
	{
		parent::__construct();
		self::$ci = & get_instance();
		self::$db = self::$ci->db;
		self::$ci->load->library('Category');
	}
	
	public static function Get( $id , $asArray = false)
	{
		
		self::$db->where('category_id' , $id);
		self::$db->limit(1);
		$query = self::$db->get(self::$table);
		
		if($asArray)
			$result = $query->result_array();
		else
			$result = $query->result('Category');
		
		if( count($result) > 0)
			return $result[0];
		else
			return NULL;
	}
	
	public function Insert($data)
	{
		self::$db->insert(self::$table,$data);
	}
	
	public static function GetCategories($level = NULL, $parent = NULL)
	{
		if( !is_null($parent) )
			self::$db->where('category_parent_id',$parent);
			
		if( !is_null($level) )
			self::$db->where('category_level',$level);
		
		self::$db->order_by('category_parent_id', 'ASC');
		
		$query = self::$db->get('category');
		
		return $query->result('Category');
	}
	
}
?>