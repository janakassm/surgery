<?php
class Advertisement_Model extends GeneralModel {
	
	private static $table = 'advertisement';
	private static $images_table = 'advertisement_image';
	private static $user_data = './user_data/advertisements/';
	private static $user_data_url = 'user_data/advertisements/';
	
	public function __construct()
    {
        parent::__construct();
	}
	
	
	
	public function Get( $id )
	{
		
		$where = array('advertisement_id'=>$id);
		
		$query = self::$db->get_where(self::$table,$where,1);
		
		
		$return = $query->result_array();
		
		if(  count($return) > 0)
			$return = $return[0];
		
		
		return $return;
	}
	
	public static function Register( $data = array() )
	{	
		
		$id = false;
		
		self::$db->insert(self::$table,$data);
		
		$id = self::$db->insert_id();
		
		return $id;
		
		
	}
	
	public static function Update( $id = NULL , $data = array() )
	{	
		if( !is_null($id) )
		{
			
			self::$db->where('advertisement_id', $id);
			self::$db->update(self::$table,$data);
			
			return true;
		}
		
		return false;
	}
	
	public static function Delete( $id = NULL)
	{
		
		if( !is_null($id) )
		{
			
			self::$db->where('advertisement_id', $id);
			self::$db->delete(self::$table);
			
			return true;
		}
		
		return false;
	}
	
	public static function ReSort($id, $page_id, $cp, $np)
	{
		
		if($np == 'down')
		{
			$sql = 'SELECT * FROM `'.self::$table.'` WHERE `advertisement_page_id` = '.$page_id.' AND `advertisement_sort_count`> '.$cp.' ORDER BY advertisement_sort_count ASC LIMIT 1';
			$query = self::$db->query($sql);
			$result = $query->result();
			
			if( !empty($result) )
			{
				$itemBelow = $result[0];
				
				self::$db->where('advertisement_id', $itemBelow->advertisement_id);
				$data = array('advertisement_sort_count' => $cp);
				self::$db->update(self::$table, $data);
				
				self::$db->where('advertisement_id', $id);
				$data = array('advertisement_sort_count' => $itemBelow->advertisement_sort_count);
				self::$db->update(self::$table, $data);
			}
			
			
			return true;
		}
		else if($np == 'up')
		{
			$sql = 'SELECT * FROM `'.self::$table.'` WHERE `advertisement_page_id` = '.$page_id.' AND `advertisement_sort_count`< '.$cp.' ORDER BY advertisement_sort_count DESC LIMIT 1';
			$query = self::$db->query($sql);
			$result = $query->result(); 
			
			if( !empty($result) )
			{
				$itemOver = $result[0];
				
				self::$db->where('advertisement_id', $itemOver->advertisement_id);
				$data = array('advertisement_sort_count' => $cp);
				self::$db->update(self::$table, $data);
				
				self::$db->where('advertisement_id', $id);
				$data = array('advertisement_sort_count' => $itemOver->advertisement_sort_count);
				self::$db->update(self::$table, $data);
			}
			
						
			return true;
		}
		
		return false;	
		
	}
	
	public static function GetAdvertisements($isPublic = NULL, $searchTag = NULL, $selectedColumns = NULL )
    {
    	self::$CI->load->library('Advertisement');
		   
		if( !is_null($selectedColumns) )
		{
			$selectQuery = "";
			if( is_array($selectedColumns) )
				$selectQuery = implode(",", $selectedColumns);
			else
				$selectQuery = $selectedColumns;
				
			self::$db->select($selectQuery);	
		}
		
		if( !is_null($isPublic) && is_bool($isPublic))		
			self::$db->where('advertisement_is_public' , $isPublic);
		
		if( !is_null($searchTag) )
		{
			self::$db->like('advertisement_title',$searchTag);
			self::$db->or_like('advertisement_body',$searchTag);
		}
		
		
		
		
    	$query = self::$db->get(self::$table);
        
        $result = $query->result('Advertisement');
		
		return $result;
	}
	
	public static function GetArticleAdvertisements($articleId , $isPublic = NULL, $searchTag = NULL )
	{
		self::$CI->load->library('Advertisement');
		
		//self::$db->where('adver' , $isPublic);
	}
	
	public static function InsertImage( $id = NULL, $fileData )
	{
		if( !is_null($id) )
		{
			$saveUrl = self::$user_data_url.$id.'/images/';
			$data = array(
						'advertisement_image_url' => $saveUrl.$fileData['fileName'],
						'advertisement_image_thumb_url' => $saveUrl.'thumb/'.$fileData['fileName'],
						'advertisement_image_index' => md5($fileData['fileName']),
						'advertisement_id' => $id							
					);
			
			self::$db->insert(self::$images_table,$data);
			return true;
		}
		return false;
	}

	public static function DeleteImage( $fileData = NULL )
	{
		if( !empty($fileData) )
		{
			self::$db->where('advertisement_image_id',$fileData['fileId']);
			self::$db->delete(self::$images_table);
			
			unlink('./'.$fileData['fileUrl']);
			unlink('./'.$fileData['fileThumbUrl']);
			
			return true;
		}
		
		return false;
	}
	
	public static function GetImageList( $id = NULL )
	{
		if( !is_null($id) )
		{
			self::$db->where('advertisement_id',$id);
			$query = self::$db->get(self::$images_table);
        	return $query->result();
		}
		return NULL;
	}

}
?>