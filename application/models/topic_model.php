<?php
class Topic_Model extends GeneralModel {
	
	private static $table = 'topic';
	private static $images_table = 'topic_image';
	private static $user_data = './user_data/topics/';
	private static $user_data_url = 'user_data/topics/';
	
	public function __construct()
    {
        parent::__construct();
	}
	
	
	
	public function Get( $id )
	{
		
		$where = array('topic_id'=>$id);
		
		$query = self::$db->get_where(self::$table,$where,1);
		
		
		$return = $query->result_array();
		
		if(  count($return) > 0)
			$return = $return[0];
		
		
		return $return;
	}
	
	public static function Register( $data = array() )
	{	
		
		$id = false;
		
		self::$db->select_min('topic_sort_count','min_count');
		
		$res = self::$db->get(self::$table);
		
		$value = $res->result();
		$min_count = ($value[0]->min_count)-1;
		
		$data['topic_sort_count'] = $min_count;
		
		self::$db->insert(self::$table,$data);
		
		$id = self::$db->insert_id();
		
		return $id;
		
		
	}
	
	public static function Update( $id = NULL , $data = array() )
	{	
		if( !is_null($id) )
		{
			
			self::$db->where('topic_id', $id);
			self::$db->update(self::$table,$data);
			
			return true;
		}
		
		return false;
		
	}
	
	public static function Delete( $id = NULL)
	{
		
		if( !is_null($id) )
		{
			
			self::$db->where('topic_id', $id);
			self::$db->delete(self::$table);
			
			return true;
		}
		
		return false;
	}
	
	public static function ReSort($id, $page_id, $cp, $np)
	{
		
		if($np == 'down')
		{
			$sql = 'SELECT * FROM `'.self::$table.'` WHERE `topic_page_id` = '.$page_id.' AND `topic_sort_count`> '.$cp.' ORDER BY topic_sort_count ASC LIMIT 1';
			$query = self::$db->query($sql);
			$result = $query->result();
			
			if( !empty($result) )
			{
				$itemBelow = $result[0];
				
				self::$db->where('topic_id', $itemBelow->topic_id);
				$data = array('topic_sort_count' => $cp);
				self::$db->update(self::$table, $data);
				
				self::$db->where('topic_id', $id);
				$data = array('topic_sort_count' => $itemBelow->topic_sort_count);
				self::$db->update(self::$table, $data);
			}
			
			
			return true;
		}
		else if($np == 'up')
		{
			$sql = 'SELECT * FROM `'.self::$table.'` WHERE `topic_page_id` = '.$page_id.' AND `topic_sort_count`< '.$cp.' ORDER BY topic_sort_count DESC LIMIT 1';
			$query = self::$db->query($sql);
			$result = $query->result(); 
			
			if( !empty($result) )
			{
				$itemOver = $result[0];
				
				self::$db->where('topic_id', $itemOver->topic_id);
				$data = array('topic_sort_count' => $cp);
				self::$db->update(self::$table, $data);
				
				self::$db->where('topic_id', $id);
				$data = array('topic_sort_count' => $itemOver->topic_sort_count);
				self::$db->update(self::$table, $data);
			}
			
						
			return true;
		}
		
		return false;	
		
	}
	
	public static function GetTopics($articleId = NULL, $isPublic = NULL, $searchTag = NULL, $selectedColumns = NULL )
    {
    	self::$CI->load->library('Topic');
		   
		if( !is_null($selectedColumns) )
		{
			$selectQuery = "";
			if( is_array($selectedColumns) )
				$selectQuery = implode(",", $selectedColumns);
			else
				$selectQuery = $selectedColumns;
				
			self::$db->select($selectQuery);	
		}
		
		if( !is_null($articleId) )
			self::$db->where('topic_article', $articleId);
		
		
		
		if( !is_null($isPublic) && is_bool($isPublic))		
			self::$db->where('topic_is_public' , $isPublic);
		
		if( !is_null($searchTag) )
		{
			self::$db->like('topic_heading',$searchTag);
			self::$db->or_like('topic_content',$searchTag);
		}
		
		self::$db->order_by('topic_sort_count','ASC');
		self::$db->order_by('topic_article','ASC');
		
    	$query = self::$db->get(self::$table);
        
        $result = $query->result('Topic');
		
		return $result;
	}
	
	public static function InsertImage( $id = NULL, $fileData )
	{
		if( !is_null($id) )
		{
			$saveUrl = self::$user_data_url.$id.'/images/';
			$data = array(
						'topic_image_url' => $saveUrl.$fileData['fileName'],
						'topic_image_thumb_url' => $saveUrl.'thumb/'.$fileData['fileName'],
						'topic_image_index' => md5($fileData['fileName']),
						'topic_id' => $id							
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
			self::$db->where('topic_image_id',$fileData['fileId']);
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
			self::$db->where('topic_id',$id);
			$query = self::$db->get(self::$images_table);
        	return $query->result();
		}
		return NULL;
	}

}
?>