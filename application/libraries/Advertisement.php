<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Advertisement extends GeneralClass
{
	public $advertisement_id = NULL;
	public $advertisement_title = '';
	public $advertisement_brief = '';
	public $advertisement_body = '';
	//public $advertisement_image = '';
	//public $advertisement_image_thumb = '';
	public $advertisement_start_date = NULL;
	public $advertisement_expire_date = NULL;
	public $advertisement_is_public = true;
	public $advertisement_is_saved = false;
	public $advertisement_is_expiring = false;
	
	private $img_list = NULL;
	
	public function __construct()
	{
		parent::__construct();
		$this->CI->load->model('Advertisement_Model','advertisement_manager');
	}
	
	public function IsAdvertisement( $refreshObject = true,$byTitle =false )
	{
		if( $data = $this->CI->advertisement_manager->Get($this->advertisement_id) )
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
		if( !is_null($this->advertisement_id) )
		{
			$this->img_list = array();
			$imgList = Advertisement_Model::GetImageList($this->advertisement_id);
			
			foreach($imgList as $img)
			{
				$this->img_list[$img->advertisement_image_index] = array('fileUrl'=>$img->advertisement_image_url, 'fileThumbUrl'=>$img->advertisement_image_thumb_url, 'fileId'=>$img->advertisement_image_id);
			}
		}
	}
	
	public function Save()
	{
		//check if the item aleady saved or if not register a new one
		if( $this->IsAdvertisement(false) )
		{
			if( $this->Update() )
				return true;
			
		}
		else
		{
			if( $id = $this->Register() )
			{
				$this->advertisement_id = $id;
				return true;
			}
			
		}
		
		return false;
	}
	
	public function ReSort($newPosition)
	{
		
	}
	
	public function InsertImage($fileData)
	{
		if( !is_null($fileData) )
		{
			if( !is_array($this->img_list) )
			{
				$this->img_list = array();
			}
			
			if( Advertisement_Model::InsertImage($this->advertisement_id , $fileData['data']) )
			{
				$this->img_list[$fileData['index']] = $fileData['data'];			
			
				return true;
			}
			
		}
		
		return false;
	}
	
	public function DeleteImage($fileId = NULL)
	{
		if( !is_null($fileId) )
		{
			if( array_key_exists($fileId, $this->img_list) )
			{
				if( Advertisement_Model::DeleteImage($this->img_list[$fileId]) )
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
		if ( Advertisement_Model::Delete($this->advertisement_id) )
		{
			return true;
		}
		
		return false;
	}
	
	
	public function PreRegister()
	{
		$this->advertisement_is_saved = false;
		$this->advertisement_is_public = false;
		$this->advertisement_start_date = date('Y-m-d H:i:s');
		$this->advertisement_id = $this->Register();
		
		return $this->advertisement_id;
	}
	
	private function Register()
	{
		$this->advertisement_is_saved = true;
		$data = $this->GetObjectVars();
		
		unset($data['advertisement_id']);
		
		$new_id = Advertisement_Model::Register(	$data );
		
		if($new_id)
		{
			
		}
		
		return $new_id;
	}
	
	private function Update()
	{
		$this->advertisement_is_saved = true;
		$data = $this->GetObjectVars();
		
		unset($data['advertisement_id']);
		
		return Advertisement_Model::Update( $this->advertisement_id, $data );
	}
	
	public static function GetAdvertisements($articleId =NULL,$searchTag = NULL)
	{
		return Advertisement_Model::GetAdvertisements($articleId,$searchTag);
	}
	
	
}
