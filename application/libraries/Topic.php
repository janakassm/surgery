<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Topic extends GeneralClass
{
	public $topic_id = NULL;
	public $topic_article = NULL;
	public $topic_heading = '';
	public $topic_content = '';
	public $topic_is_public = true;
	public $topic_is_saved = true;
	public $topic_sort_count = 0;
	
	private $img_list = NULL;
	private $video_list = NULL;
	
	public function __construct()
	{
		parent::__construct();
		$this->CI->load->model('Topic_Model','topic_manager');
	}
	
	
	public function IsTopic( $refreshObject = true,$byTitle =false )
	{
		if( $data = $this->CI->topic_manager->Get($this->topic_id) )
		{
			if($refreshObject)
				$this->ParseToObject($data);
			return true;
		} 
		else
			return false;
		
	}
	
	public function Refresh()
	{
		if( !is_null($this->topic_id) )
		{
			$this->img_list = array();
			$imgList = Topic_Model::GetImageList($this->topic_id);
			
			foreach($imgList as $img)
			{
				$this->img_list[$img->topic_image_index] = array('fileUrl'=>$img->topic_image_url, 'fileThumbUrl'=>$img->topic_image_thumb_url, 'fileId'=>$img->topic_image_id, 'fileIndex'=>$img->topic_image_index);
			}
		}
	}
	
	public function Save()
	{
		//check if the item aleady saved or if not register a new one
		if( $this->IsTopic(false) )
		{
			if( $this->Update() )
				return true;
			
		}
		else
		{
			if( $id = $this->Register() )
			{
				$this->topic_id = $id;
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
	
	
	public function SetImageList($imageList)
	{
		$this->img_list = $imageList;		
	}
	
	public function GetImageList()
	{
		return $this->img_list;		
	}
	
	public function GetVideo()
	{
		return $this->video_list;
	}
	
	
	public function InsertImage($fileData)
	{
		if( !is_null($fileData) )
		{
			if( !is_array($this->img_list) )
			{
				$this->img_list = array();
			}
			
			if( Topic_Model::InsertImage($this->topic_id , $fileData['data']) )
			{
				$this->img_list[$fileData['index']] = $fileData['data'];			
			
				return true;
			}
			
		}
		
		return false;
	}
	
	public function InsertVideo($url)
	{
		if( trim($url) != "" && !empty($this->topic_id) )
		{
			return Topic_Model::InsertVideo($this->topic_id, $url);
		}
		
		return false;
	}
	
	public function DeleteVideo($videoId)
	{
		return Topic_Model::DeleteVideo($this->topic_id, $videoId);
	}
	
	public function DeleteImage($fileId = NULL)
	{
		if( !is_null($fileId) )
		{
			if( array_key_exists($fileId, $this->img_list) )
			{
				if( Topic_Model::DeleteImage($this->img_list[$fileId]) )
				{
					unset($this->img_list[$fileId]);
					return true;
				}
				
			}
		}
		
		return false;
	}
	
	public function Delete()
	{
		if ( Topic_Model::Delete($this->topic_id) )
		{
			return true;
		}
		
		return false;
	}
	
	
	public function PreRegister($articleId)
	{
		$this->topic_article = $articleId;
		$this->topic_is_saved = false;
		$this->topic_is_public = false;
		$this->topic_id = $this->Register();
		
		return $this->topic_id;
	}
	
	private function Register()
	{
		$this->topic_is_saved = true;
		$data = $this->GetObjectVars();
		
		unset($data['topic_id']);
		
		$new_id = Topic_Model::Register(	$data );
		
		if($new_id)
		{
			
		}
		
		return $new_id;
	}
	
	private function Update()
	{
		$this->topic_is_saved = true;
		$data = $this->GetObjectVars();
		
		unset($data['topic_id']);
		
		return Topic_Model::Update( $this->topic_id, $data );
	}
	
	public static function GetTopics($articleId =NULL,$searchTag = NULL)
	{
		return Topic_Model::GetTopics($articleId,$searchTag);
	}
	
	
}
