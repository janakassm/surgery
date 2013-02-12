<?php
class Article_Model extends GeneralModel {
	
	private static $table = 'article';
	private static $category_table = 'article_category';
	
	public function __construct()
    {
        parent::__construct();
	}
	
	public function GetPage( $id )
	{
		
		if( !is_null($id) )
		{
			
			$where = array('page_id'=>$id);
		
			$query = self::$db->get_where('page',$where,1);
			
			
			
			$return = $query->result();
			
			if(  count($return) > 0)
				$return = $return[0];
			
			
			return $return;
		}
		return NULL;
	}
	
	public static function Get( $id )
	{
		
		$where = array('article_id'=>$id);
		
		$query = self::$db->get_where(self::$table,$where,1);
		
		
		$return = $query->result_array();
		
		if(  count($return) > 0)
			$return = $return[0];
		
		
		return $return;
	}
	
	
	public static function Register( $data = array() )
	{	
		
		$id = false;
		
		self::$db->select_min('article_sort_count','min_count');
		
		$res = self::$db->get(self::$table);
		
		$value = $res->result();
		$min_count = ($value[0]->min_count)-1;
		
		$data['article_sort_count'] = $min_count;
		
		self::$db->insert(self::$table,$data);
		
		$id = self::$db->insert_id();
		
		return $id;
		
		
	}
	
	public static function Update( $id  , $data )
	{	
		if( !is_null($id) )
		{
			
			self::$db->where('article_id', $id);
			self::$db->update(self::$table,$data);
			
			return true;
		}
		
		return false;
		
	}
	
	public static function Detele( $id )
	{
		
		if( !is_null($id) )
		{
			$data = array('article_is_deleted' => true);
			self::$db->where('article_id', $id);
			self::$db->update(self::$table,$data);
			
			return true;
		}
		
		return false;
	}
	
	
	
	public static function ReSort($id, $page_id, $cp, $np)
	{
		
		if($np == 'down')
		{
			$sql = 'SELECT * FROM `'.self::$table.'` WHERE `article_page_id` = '.$page_id.' AND `article_sort_count`> '.$cp.' ORDER BY article_sort_count ASC LIMIT 1';
			$query = self::$db->query($sql);
			$result = $query->result();
			
			if( !empty($result) )
			{
				$itemBelow = $result[0];
				
				self::$db->where('article_id', $itemBelow->article_id);
				$data = array('article_sort_count' => $cp);
				self::$db->update(self::$table, $data);
				
				self::$db->where('article_id', $id);
				$data = array('article_sort_count' => $itemBelow->article_sort_count);
				self::$db->update(self::$table, $data);
			}
			
			
			return true;
		}
		else if($np == 'up')
		{
			$sql = 'SELECT * FROM `'.self::$table.'` WHERE `article_page_id` = '.$page_id.' AND `article_sort_count`< '.$cp.' ORDER BY article_sort_count DESC LIMIT 1';
			$query = self::$db->query($sql);
			$result = $query->result(); 
			
			if( !empty($result) )
			{
				$itemOver = $result[0];
				
				self::$db->where('article_id', $itemOver->article_id);
				$data = array('article_sort_count' => $cp);
				self::$db->update(self::$table, $data);
				
				self::$db->where('article_id', $id);
				$data = array('article_sort_count' => $itemOver->article_sort_count);
				self::$db->update(self::$table, $data);
			}
			
						
			return true;
		}
		
		return false;	
		
	}


	public static function InsertCategory( $articleId, $categoryId )
	{	
		
		$id = false;
		
		$data = array(
			'article_id' => $articleId,
			'category_id' => $categoryId
		);
		
		self::$db->insert(self::$category_table,$data);
		
		return $categoryId;
		
		
	}
	
	public static function DeteleCategory( $articleId, $categoryId )
	{
		
		if( !is_null($articleId) && !is_null($categoryId) )
		{
			self::$db->where('article_id', $articleId);
			self::$db->where('category_id', $categoryId);
			self::$db->delete(self::$category_table);
			
			return true;
		}
		
		return false;
	}
	
	public static function GetArticles($categoryId = NULL, $isPublic = NULL, $searchTag = NULL, $selectedColumns = NULL )
    {
    	self::$CI->load->library('Article');
		   
		if( !is_null($selectedColumns) )
		{
			$selectQuery = "";
			if( is_array($selectedColumns) )
				$selectQuery = implode(",", $selectedColumns);
			else
				$selectQuery = $selectedColumns;
				
			self::$db->select($selectQuery);	
		}
		
		if( !is_null($categoryId) )
			self::$db->where('article_category', $categoryId);
		
		
		
		if( !is_null($isPublic) && is_bool($isPublic))		
			self::$db->where('article_is_public' , $isPublic);
		
		if( !is_null($searchTag) )
		{
			self::$db->like('article_title',$searchTag);
			self::$db->or_like('article_content',$searchTag);
		}
		
		self::$db->where('article_is_saved' , true);
		self::$db->where('article_is_deleted' , false);
		
		self::$db->order_by('article_sort_count','ASC');
		self::$db->order_by('article_category','ASC');
		
    	$query = self::$db->get(self::$table);
        
        $result = $query->result('Article');
		
		return $result;
	}
	
	public static function GetArticleCategories($article_id)
	{
		self::$db->where('article_id' , $article_id);
		self::$db->join('category', 'category.category_id = '.self::$category_table.'.category_id');
		return $query = self::$db->get(self::$category_table)->result();
	}
}
?>