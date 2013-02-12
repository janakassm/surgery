<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Article extends GeneralClass
{
	public $article_id = NULL;
	public $article_title = '';
	
	public $article_is_public = true;
	public $article_is_saved = true;
	public $article_sort_count = 0;
	
	private $img_list = array();
	private $topic_list = array();
	private $category_list = array();
	
	
	public function __construct()
	{
		parent::__construct();
		$this->CI->load->model('Article_Model','article_manager');
	}
	
	
	public function IsArticle( $refreshObject = true,$byTitle =false)
	{
		
		if( $byTitle && $data = Article_Model::Get(NULL, $this->article_title) )
		{
			if($refreshObject)
			{
				$this->Refresh($data);
			}
			return true;
		}
		else if( $data = Article_Model::Get($this->article_id) )
		{
			if($refreshObject)
			{
				$this->Refresh($data);
			}
			return true;
		} 
		else
			return false;
		
	}
	
	public function Refresh($data = null)
	{
		if( !is_null($this->article_id) )
		{
			if($data == null)
				$data = Article_Model::Get($this->article_id);
			$this->ParseToObject($data);
			
			$this->category_list = Article_Model::GetArticleCategories($this->article_id);
		}
	}
	
	public function Save()
	{
		//check if the item aleady saved or if not register a new one
		if( $this->IsArticle(false) )
		{
			if( $this->Update() )
				return true;
			
		}
		else
		{
			if( $id = $this->Register() )
			{
				$this->article_id = $id;
				return true;
			}
			
		}
		
		return false;
	}
	
	public function ReSort($newPosition)
	{
		
	}
	
	public function SetImageList360($imageList)
	{
		$this->img_list_360 = $imageList;		
	}
	
	public function GetImageList360()
	{
		if( is_null($this->img_list_360) )
			$this->Refresh();
		
		return $this->img_list_360;		
	}
	
	public function GetImage360Data()
	{
		if( $this->article_img_360 )
		{
			$imageCount = count ( $this->GetImageList360() );
			$numOfPoints = "";
			if($imageCount > 10)
			{
				for($x=1; $x<= strlen( $imageCount ); $x++ )
				{
					$numOfPoints .= "#";
				}
			}
			else 
			{
				$numOfPoints = "##";
			}
			
			
			$imgDir = Article_Model::Get360DirUrl( $this->article_id );
			
			$resultObj = NULL;
			$resultObj->code = base_url().$imgDir.$numOfPoints.".jpg|1..".$imageCount."|1";
			$resultObj->numOfFrames = $imageCount;
			
			return $resultObj;
		}
		
		return NULL;	
	}
	
	public function SetImageList($imageList)
	{
		$this->img_list = $imageList;		
	}
	
	public function GetImageList()
	{
		return $this->img_list;		
	}
	
	public function InsertImage($fileData)
	{
		if( !is_null($fileData) )
		{
			if( !is_array($this->img_list) )
			{
				$this->img_list = array();
			}
			
			if( Article_Model::InsertImage($this->article_id , $fileData['data']) )
			{
				$this->img_list[$fileData['index']] = $fileData['data'];			
			
				return true;
			}
			
		}
		
		return false;
	}
	
	public function InsertImage360($fileData)
	{
		if( !is_null($fileData) )
		{
			if( !is_array($this->img_list_360) )
			{
				$this->img_list_360 = array();
			}
			
			$this->img_list_360[$fileData['index']] = $fileData['data'];			
			
			return true;
			
		}
		
		return false;
	}
	
	public function InsertCategory($categoryId)
	{
		if(!is_null($categoryId))
		{
			Article_Model::InsertCategory($this->article_id, $categoryId);
			$this->Refresh();
			return true;
		}
		
		return false;
	}
	
	public function DeleteImage($fileId = NULL)
	{
		if( !is_null($fileId) )
		{
			if( array_key_exists($categoryId, $this->img_list) )
			{
				if( Article_Model::DeleteImage($this->img_list[$fileId]) )
				{
					unset($this->img_list[$fileId]);
					return true;
				}
			}
		}
		
		return false;
	}
	
	public function DeleteImage360($fileId = NULL)
	{
		if( !is_null($fileId) )
		{
			if( array_key_exists($fileId, $this->img_list_360) )
			{
				if( Article_Model::DeleteImage360($this->img_list_360[$fileId]) )
				{
					unset($this->img_list_360[$fileId]);
					return true;
				}
			}
		}
		
		return false;
	}
	
	public function DeleteCategory($categoryId)
	{
		if( !is_null($categoryId) )
		{
			if( Article_Model::DeteleCategory($this->article_id, $categoryId) )
			{
				$this->Refresh();
				return true;
			}
		}
		
		return false;
	}
	
	
	public function Delete()
	{
		if ( Article_Model::Detele($this->article_id) )
		{
			/*foreach ($this->img_list as $index => $image) {
				$this->DeleteImage($index);
			}
			
			foreach ($this->img_list_360 as $index => $image) {
				$this->DeleteImage360($index);
			}*/
			return true;
		}
		
		return false;
	}
	
	public function GetCoverImage()
	{
		if( empty($this->img_list) )
		{
			$this->Refresh();
		}
		
		if( !is_null($this->article_cover_image_index) )
		{
			if(	array_key_exists($this->article_cover_image_index, $this->img_list) )
			{
				return $this->img_list[$this->article_cover_image_index]['fileUrl'];
			}
		}
		else if ( count($this->img_list) > 0 )
		{
			return $this->img_list[0]['fileUrl'];
		}
		else
		{
			return 'images/no_image.jpg';
		}
		return false;
	}
	
	public function GetCategoryList()
	{
		return $this->category_list;
	}
	
	
	public function PreRegister()
	{
		$this->article_is_public = false;
		$this->article_is_saved = false;
		
		$this->article_id = $this->Register();
	}
	
	private function Register()
	{
		$data = $this->GetObjectVars();
		
		unset($data['article_id']);
		
		$new_id = Article_Model::Register(	$data );
		
		if($new_id)
		{
			if( !empty($this->img_list) )
			{
				//Article_Model::InsertImages($new_id,$this->img_list);
			}
			
			if( !empty($this->topic_list) )
			{
				/*if( $folderUrl = Article_Model::Insert360Images($new_id, $this->img_list_360) )
				{
					$this->article_img_360 = $folderUrl;
				}
				
				$this->Update();*/
			}
		}
		
		return $new_id;
	}
	
	
	public function GetArticleCategoryTitle()
	{
		$this->CI->load->library('Category');
		
		$category  = new Category();
		$category->category_id = $this->article_category;
		
		if($category->IsCategory())
		{
			return $category->category_title_sin;
		}
		else
			return NULL;
	}

	public function GetTopics()
	{
		$this->CI->load->library('Topic');
		return Topic::GetTopics($this->article_id);
	}
	
	private function Update()
	{
		$data = $this->GetObjectVars();
		
		unset($data['article_id']);
		
		return Article_Model::Update( $this->article_id, $data );
	}
	
	public static function GetArticles($categoryId =NULL,$searchTag = NULL)
	{
		return Article_Model::GetArticles($categoryId,$searchTag);
	}
	
	
}
