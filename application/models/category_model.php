<?php
class Category_Model extends CI_Model {
	
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
		self::$db->where('category_is_deleted',false);
		
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
	
	public static function Insert($data)
	{
		self::$db->insert(self::$table,$data);
		
		return self::$db->insert_id();
	}
	
	public static function Update($id, $data)
	{
		self::$db->where('category_id', $id);
		
		self::$db->update(self::$table, $data);
		
	}
	
	public static function Delete($id)
	{
		self::$db->where('category_id', $id);
		
		$data = array(
					'category_is_deleted' => true	
				);
		
		self::$db->update(self::$table, $data);
		
	}
	
	public static function GetCategories($level, $parent)
	{
		self::$db->where('category_parent_id',$parent);
			
		if( !is_null($level) )
			self::$db->where('category_level',$level);
		
		self::$db->where('category_is_deleted',false);
		
		self::$db->order_by('category_parent_id', 'ASC');
		
		$query = self::$db->get('category');
		
		return $query->result();
	}
	
}
?>